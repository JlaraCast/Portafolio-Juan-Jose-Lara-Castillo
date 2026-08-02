#!/usr/bin/env python3
"""Build a self-hosted Devicon subset containing only the icons the site uses.

Full Devicon is ~130 KB of CSS plus a ~1.5 MB font served from a third-party
CDN, which blocks rendering and ships a lot of unused CSS. This script downloads
the original, keeps the classes listed in ICON_CLASSES and writes
public/vendor/devicon/{devicon.css,devicon.woff2}.

Requires: pip install fonttools brotli
Usage:    python scripts/build-devicon-subset.py

When a new skill is added through the admin panel with a Devicon icon, add its
class here and re-run the script.
"""

import re
import sys
import tempfile
import urllib.request
from pathlib import Path

DEVICON_VERSION = "2.17.0"
BASE_URL = f"https://cdn.jsdelivr.net/gh/devicons/devicon@{DEVICON_VERSION}"
OUT_DIR = Path(__file__).resolve().parent.parent / "public" / "vendor" / "devicon"

# Classes used by database/seeders/SkillSeeder.php
ICON_CLASSES = [
    "devicon-amazonwebservices-plain-wordmark",
    "devicon-bootstrap-plain",
    "devicon-csharp-plain",
    "devicon-css3-plain",
    "devicon-docker-plain",
    "devicon-html5-plain",
    "devicon-java-plain",
    "devicon-javascript-plain",
    "devicon-laravel-original",
    "devicon-linux-plain",
    "devicon-mysql-plain",
    "devicon-php-plain",
]

RULE_RE = re.compile(r"((?:\.[\w-]+:before,?)+)\{content:\"([^\"]+)\"\}")


def fetch(url: str) -> bytes:
    request = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urllib.request.urlopen(request) as response:
        return response.read()


def main() -> int:
    try:
        from fontTools import subset
        from fontTools.ttLib import TTFont
    except ImportError:
        print("fonttools is missing. Install with: pip install fonttools brotli", file=sys.stderr)
        return 1

    css = fetch(f"{BASE_URL}/devicon.min.css").decode("utf-8-sig")
    wanted = set(ICON_CLASSES)
    rules, codepoints, found = [], set(), set()

    for selectors, glyph in RULE_RE.findall(css):
        names = {s.split(":")[0].lstrip(".") for s in selectors.split(",") if s}
        matched = names & wanted
        if not matched:
            continue
        found |= matched
        codepoints.add(ord(glyph))
        rules.append(
            ",".join(f".{name}:before" for name in sorted(matched))
            + '{content:"\\%x"}' % ord(glyph)
        )

    missing = wanted - found
    if missing:
        print(f"Classes not found in Devicon {DEVICON_VERSION}: {sorted(missing)}", file=sys.stderr)
        return 1

    OUT_DIR.mkdir(parents=True, exist_ok=True)

    with tempfile.TemporaryDirectory() as tmp:
        source = Path(tmp) / "devicon.ttf"
        source.write_bytes(fetch(f"{BASE_URL}/fonts/devicon.ttf"))

        font = TTFont(source)
        subsetter = subset.Subsetter(
            options=subset.Options(layout_features=[], notdef_outline=False, drop_tables=["DSIG"])
        )
        subsetter.populate(unicodes=codepoints)
        subsetter.subset(font)
        font.flavor = "woff2"
        font.save(OUT_DIR / "devicon.woff2")

    # font-display: swap instead of the original "block", so neighbouring text
    # is not left invisible while the icon font downloads.
    stylesheet = (
        "@font-face{font-family:\"devicon\";"
        "src:url(\"devicon.woff2\") format(\"woff2\");"
        "font-weight:normal;font-style:normal;font-display:swap}"
        "[class^=devicon-],[class*=\" devicon-\"]{font-family:\"devicon\"!important;"
        "speak:never;font-style:normal;font-weight:normal;font-variant:normal;"
        "text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;"
        "-moz-osx-font-smoothing:grayscale}"
        + "".join(sorted(rules))
        + "\n"
    )
    (OUT_DIR / "devicon.css").write_text(stylesheet, encoding="utf-8")

    css_kb = len(stylesheet) / 1024
    font_kb = (OUT_DIR / "devicon.woff2").stat().st_size / 1024
    print(f"{len(found)} icons -> devicon.css {css_kb:.1f} KB, devicon.woff2 {font_kb:.1f} KB")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
