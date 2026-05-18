// export async function post(url, data = {}) {
//     try {
//         const res = await fetch(window.BASE_URL + url, {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/x-www-form-urlencoded"
//             },
//             body: new URLSearchParams(data)
//         });

//         if (!res.ok) throw new Error("HTTP error");

//         return await res.json();

//     } catch (error) {
//         console.error("API ERROR:", error);
//         return { success: false };
//     }
// }

export async function post(url, data = {}) {
    try {

        const base = window.BASE_URL || "";
        const fullUrl = base + url;

        const res = await fetch(fullUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data)
        });

        if (!res.ok) throw new Error("HTTP error");

        return await res.json();

    } catch (error) {
        console.error("API ERROR:", error);
        return { success: false };
    }
}