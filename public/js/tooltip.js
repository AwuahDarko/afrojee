document.querySelectorAll('[data-tooltip-target]').forEach(element => {
    const tooltip = element.nextElementSibling;
    if (!tooltip || !tooltip.classList.contains('tooltip')) return;
    // console.log('Tooltip found for element:', element);
    element.addEventListener('mouseenter', () => {
        tooltip.classList.add('show');
        // Optional: Adjust position dynamically
        const rect = element.getBoundingClientRect();
        tooltip.style.top = `${rect.bottom + window.scrollY + 8}px`;
        tooltip.style.left = `${rect.left + rect.width / 2}px`;
    });

    element.addEventListener('mouseleave', () => {
        tooltip.classList.remove('show');
    });
});