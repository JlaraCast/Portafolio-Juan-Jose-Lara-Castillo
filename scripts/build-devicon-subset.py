#!/usr/bin/env python3
"""Build a self-hosted Devicon subset containing only the icons the site uses.

Full Devicon is ~130 KB of CSS plus a ~1.5 MB font served from a third-party
CDN, which blocks rendering and ships a lot of unused CSS. This script downloads
the original, keeps the classes listed in ICON_CLASSES and writes
public/vendor/devicon/{devicon.css,devicon.woff2}.

Requires: pip install fonttools brotli
Usage:    python scripts/build-devicon-subset.py
          python scripts/build-devicon-subset.py --from-url https://example.com

When a new skill is added through the admin panel with a Devicon icon, add its
class to ICON_CLASSES and re-run the script, otherwise that icon renders blank.
Passing --from-url reads the classes a deployed page renders and reports any
that ICON_CLASSES is missing.
"""

import re
import sys
import tempfile
import urllib.request
from pathlib import Path

DEVICON_VERSION = "2.17.0"
BASE_URL = f"https://cdn.jsdelivr.net/gh/devicons/devicon@{DEVICON_VERSION}"
OUT_DIR = Path(__file__).resolve().parent.parent / "public" / "vendor" / "devicon"

# Icon classes stored in the skills table. The seeder only covers part of this
# list; the rest was added through the admin panel. Run with --from-url to
# check it against what a deployed page actually renders.
ICON_CLASSES = [
    "devicon-amazonwebservices-plain-wordmark",
    "devicon-bootstrap-plain",
    "devicon-chartjs-plain",
    "devicon-csharp-plain",
    "devicon-css3-plain",
    "devicon-docker-plain",
    "devicon-git-plain",
    "devicon-html5-plain",
    "devicon-java-plain",
    "devicon-javascript-plain",
    "devicon-jquery-plain",
    "devicon-laravel-original",
    "devicon-linux-plain",
    "devicon-mysql-plain",
    "devicon-npm-plain",
    "devicon-php-plain",
    "devicon-postgresql-plain",
    "devicon-prisma-plain",
    "devicon-tailwindcss-plain",
    "devicon-vercel-plain",
    "devicon-vite-plain",
]

RULE_RE = re.compile(r"((?:\.[\w-]+:before,?)+)\{content:\"([^\"]+)\"\}")


def fetch(url: str) -> bytes:
    request = urllib.request.Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urllib.request.urlopen(request) as response:
        return response.read()


def classes_rendered_by(url: str) -> set[str]:
    """Icon classes a deployed page actually renders, to catch skills added
    through the admin panel that never made it into ICON_CLASSES."""
    return set(re.findall(r"devicon-[a-z0-9-]+", fetch(url).decode("utf-8", "replace")))


def main() -> int:
    try:
        from fontTools import subset
        from fontTools.ttLib import TTFont
    except ImportError:
        print("fonttools is missing. Install with: pip install fonttools brotli", file=sys.stderr)
        return 1

    wanted = set(ICON_CLASSES)

    if "--from-url" in sys.argv:
        url = sys.argv[sys.argv.index("--from-url") + 1]
        live = classes_rendered_by(url)
        if extra := live - wanted:
            print(f"Rendered by {url} but absent from ICON_CLASSES: {sorted(extra)}")
            wanted |= extra
        else:
            print(f"ICON_CLASSES covers every icon {url} renders")

    css = fetch(f"{BASE_URL}/devicon.min.css").decode("utf-8-sig")
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
