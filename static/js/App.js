import Toast from "./Module/Toast.js";

export default class App {
    #toast;

    constructor() {
        this.#toast = new Toast();

        document.querySelectorAll('[data-ajax]').forEach((form) => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);

                const request = new Request(e.target.attributes.action.value, {
                    method: "POST",
                    body: formData,
                });

                const res = await fetch(request);

                if (res.ok) {
                    if (res.redirected) {
                        return window.location.href = res.url;
                    }
                    if (e.target.dataset.reload !== undefined) {
                        window.location.reload();
                    }

                    const json = await res.json();

                    this.#toast.success(json.message);
                } else {
                    this.#toast.error(res.statusText);
                }
            })
        });
    }
}