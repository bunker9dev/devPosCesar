

export async function post(url, data = {}) {
    try {

        const isAbsolute = /^https?:\/\//i.test(url);
        const base = window.BASE_URL || "";
        const fullUrl = isAbsolute ? url : base + url;

        const res = await fetch(fullUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data)
        });

        if (!res.ok) {
            const text = await res.text();
            throw new Error(text || "HTTP error");
        }

        return await res.json();

    } catch (error) {
        console.error("API ERROR:", error);
        throw error;
    }
}