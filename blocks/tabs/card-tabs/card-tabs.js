document.querySelectorAll(".card-tabs--tabs button").forEach((tab) => {
  tab.addEventListener("click", () => {
    // Deselect all tabs and hide all panels
    document.querySelectorAll(".card-tabs--tabs button").forEach((t) => {
      t.setAttribute("aria-selected", "false");
    });
    document
      .querySelectorAll('.card-tabs--content [role="tabpanel"]')
      .forEach((panel) => {
        panel.hidden = true;
      });

    // Select the clicked tab and show the associated panel
    tab.setAttribute("aria-selected", "true");
    const panelId = tab.getAttribute("aria-controls");
    const panel = document.getElementById(panelId);
    panel.hidden = false;

    // Reset animations for cards in the new tab
    const cards = panel.querySelectorAll(".gpt-card");
    cards.forEach((card) => {
      // Remove the animation class
      card.classList.remove("aos-animate");

      // Add the animation class back after a delay
      setTimeout(() => {
        card.classList.add("aos-animate");
      }, 50); // Adjust delay as needed
    });
  });
});
