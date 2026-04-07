import { ref } from "vue";

const STORAGE_KEY = "theme";

export const isDark = ref(false);

export function initTheme() {
  const theme = localStorage.getItem(STORAGE_KEY) || "light";
  applyTheme(theme);
}

export function toggleTheme() {
  return applyTheme(isDark.value ? "light" : "dark");
}

export async function applyTheme(theme) {
  const html = document.documentElement;
  let badgeResponse = null;

  if (theme === "dark") {
    html.classList.add("dark");
    isDark.value = true;

    const token = localStorage.getItem("token");

    if (token) {
      try {
        const res = await fetch("http://backend.vm1.test/api/badges/dark-side", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        if (res.ok) {
          badgeResponse = await res.json();
        }
      } catch (err) {
        console.error("Error checking dark side badge:", err);
      }
    }
  } else {
    html.classList.remove("dark");
    isDark.value = false;
  }

  localStorage.setItem(STORAGE_KEY, theme);

  return badgeResponse;
}
