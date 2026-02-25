import { ref } from "vue";

const STORAGE_KEY = "theme";

export const isDark = ref(false);

export function initTheme() {
  const theme = localStorage.getItem(STORAGE_KEY) || "light";
  applyTheme(theme);
}

export function toggleTheme() {
  applyTheme(isDark.value ? "light" : "dark");
}

export function applyTheme(theme) {
  const html = document.documentElement;

  if (theme === "dark") {
    html.classList.add("dark");
    isDark.value = true;
  } else {
    html.classList.remove("dark");
    isDark.value = false;
  }

  localStorage.setItem(STORAGE_KEY, theme);
}
