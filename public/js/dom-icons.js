/**
 * SVG icon builders using DOM APIs.
 *
 * Used instead of templates assigned to innerHTML so the CSP can enforce
 * `require-trusted-types-for 'script'` without breaking these forms.
 */
(function (global) {
    const SVG_NS = 'http://www.w3.org/2000/svg';

    const PATHS = {
        check: 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z',
        cross: 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z',
    };

    function svgElement(tag, attributes) {
        const element = document.createElementNS(SVG_NS, tag);

        Object.entries(attributes).forEach(([name, value]) => element.setAttribute(name, value));

        return element;
    }

    /**
     * 20x20 icon filled with currentColor.
     */
    function statusIcon(name, className) {
        const svg = svgElement('svg', {
            class: className,
            fill: 'currentColor',
            viewBox: '0 0 20 20',
            'aria-hidden': 'true',
            focusable: 'false',
        });

        svg.appendChild(svgElement('path', {
            'fill-rule': 'evenodd',
            'clip-rule': 'evenodd',
            d: PATHS[name],
        }));

        return svg;
    }

    /**
     * Animated circular spinner.
     */
    function spinnerIcon(className) {
        const svg = svgElement('svg', {
            class: className,
            fill: 'none',
            viewBox: '0 0 24 24',
            'aria-hidden': 'true',
            focusable: 'false',
        });

        svg.appendChild(svgElement('circle', {
            class: 'opacity-25',
            cx: '12',
            cy: '12',
            r: '10',
            stroke: 'currentColor',
            'stroke-width': '4',
        }));

        svg.appendChild(svgElement('path', {
            class: 'opacity-75',
            fill: 'currentColor',
            d: 'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z',
        }));

        return svg;
    }

    /**
     * "Icon + text" row used by the validation messages.
     */
    function iconRow(iconName, text, options = {}) {
        const row = document.createElement('div');
        row.className = options.rowClass || 'flex items-center';
        row.appendChild(statusIcon(iconName, options.iconClass || 'w-4 h-4 mr-1'));
        row.appendChild(document.createTextNode(text));

        return row;
    }

    global.domIcons = { statusIcon, spinnerIcon, iconRow };
})(window);
