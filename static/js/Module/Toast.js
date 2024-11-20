export default class Toast {
    error(message) {
        this.#show('error', message);
    }

    success(message) {
        this.#show('success', message);
    }

    #show(type, message) {
        let root = document.querySelector('.toast-root');

        if (root === null) {
            root = document.createElement('div');
            root.classList.add('toast-root');
            document.body.appendChild(root);
        }

        const toastElm = document.createElement('div');
        toastElm.classList.add('toast', type);
        toastElm.textContent = message;

        root.appendChild(toastElm);

        toastElm.close = () => {
            toastElm.remove();

            if (root.querySelector('.toast') === null) {
                root.remove();
            }
        }

        setTimeout(toastElm.close, 3000);
    }
}