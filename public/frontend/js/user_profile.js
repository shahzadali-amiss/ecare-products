const buttons = document.querySelectorAll('[role="tab"]');
const tabPanel = Array.from(document.querySelectorAll('[role="tabpanel"]'));

function hideTabContent(e) {
    tabPanel.forEach((panels) => {
        panels.hidden = true;
    });
    buttons.forEach((tab) => {
        tab.setAttribute("aria-selected", false);
    });
    e.currentTarget.setAttribute("aria-selected", true);

    const { id } = event.currentTarget;
    const tabPanels = tabPanel.find(
        (tabContent) => tabContent.getAttribute("aria-labelledby") === id
    );
    tabPanels.hidden = false;
}
buttons.forEach((button) => button.addEventListener("click", hideTabContent));
