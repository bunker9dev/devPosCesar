export const Events = {

    emit(event, data = {}) {
        document.dispatchEvent(new CustomEvent(event, { detail: data }));
    },

    on(event, callback) {
        document.addEventListener(event, (e) => callback(e.detail));
    }

};