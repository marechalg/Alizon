const btnSettings: HTMLElement | null = document.getElementById('settings');

btnSettings?.addEventListener('mouseover', () => {
    const subDivs: Element[] = Array.from(btnSettings.children);
    subDivs.forEach(div => {
        if (div instanceof HTMLElement && div.firstElementChild instanceof HTMLElement) {
            const innerDiv = div.firstElementChild;
            innerDiv.style.left = innerDiv.classList.contains('right') ? '4px' : '14px';
        }
    })
})

btnSettings?.addEventListener('mouseout', () => {
    const subDivs: Element[] = Array.from(btnSettings.children);
    subDivs.forEach(div => {
        if (div instanceof HTMLElement && div.firstElementChild instanceof HTMLElement) {
            const innerDiv = div.firstElementChild;
            innerDiv.style.left = innerDiv.classList.contains('right') ? '14px' : '4px';
        }
    })
})