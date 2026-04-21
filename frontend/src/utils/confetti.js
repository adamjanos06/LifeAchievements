/**
 * Load canvas-confetti library
 * @returns {Promise<function>} Confetti function from canvas-confetti library
 */
export function loadConfetti() {
  return new Promise((resolve) => {
    
    // When already loaded
    if (window.confetti) {
      return resolve(window.confetti)
    }

    const script = document.createElement("script")
    script.src = "https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"

    script.onload = () => {
      resolve(window.confetti)
    }

    document.body.appendChild(script)
  })
}

/**
 * Fire confetti animation
 * @param {function} confetti - Confetti function from canvas-confetti
 */
export function fireConfetti(confetti) {
  if (!confetti) return

  const colors = ['#ef4444', '#3b82f6', '#22c55e', '#eab308']

  // Left
  confetti({
    particleCount: 80,
    angle: 60,
    spread: 70,
    origin: { x: 0, y: 0.6 },
    colors
  })

  // Right
  confetti({
    particleCount: 80,
    angle: 120,
    spread: 70,
    origin: { x: 1, y: 0.6 },
    colors
  })
}
