const STORAGE_KEY = "theme";

export function initTheme() {
  const theme = localStorage.getItem(STORAGE_KEY) || "light";
  applyTheme(theme);
}

export function toggleTheme() {
  const isDark = document.documentElement.classList.contains("dark");
  applyTheme(isDark ? "light" : "dark");
}

export function applyTheme(theme) {
  const html = document.documentElement;

  if (theme === "dark") {
    html.classList.add("dark");
  } else {
    html.classList.remove("dark");
  }

  localStorage.setItem(STORAGE_KEY, theme);
}
