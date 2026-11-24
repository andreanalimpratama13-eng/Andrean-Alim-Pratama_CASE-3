document.addEventListener('alpine:init', () => {
    Alpine.data('autoDismiss', () => ({
        visible: true,

        init() {
            window.setTimeout(() => {
                this.visible = false;
            }, 5000);
        },
    }));
});
