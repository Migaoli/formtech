function closeConditional() {
    return false;
}

function directive(e, el, binding) {
    binding.args = binding.args || {};

    const isActive = (binding.args.closeConditional || closeConditional);

    if (!e || isActive(e) === false) {
        return;
    }

    // ignore click if triggered programmatically
    if (('isTrusted' in e && !e.isTrusted) || ('pointerType' in e && !e.pointerType)) {
        return;
    }

    if (!clickedInsideElement(el, e.clientX, e.clientY) && isActive(e)) {
        setTimeout(() => {
            binding.value();
        });
    }

}

function clickedInsideElement(el, x, y) {
    const box = el.getBoundingClientRect();
    console.log({box, x, y});

    return x >= box.left && x <= box.right && y <= box.bottom && y >= box.top;
}

export default {
    name: 'click-outside',

    inserted(el, binding) {
        const onClick = (e) => directive(e, el, binding);

        document.body.addEventListener('click', onClick, true);
        el._clickOutside = onClick;
    },

    unbind(el) {
        document.body.removeEventListener('click', el._clickOutside, true)
    }

}