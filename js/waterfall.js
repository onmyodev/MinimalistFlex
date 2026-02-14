function resizeGridItems() {
  const grid = document.querySelector(".waterfall");
  const rowHeight = parseInt(getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  const rowGap = parseInt(getComputedStyle(grid).getPropertyValue('gap'));

  grid.querySelectorAll('.panel').forEach(item => {
    const rowSpan = Math.ceil((item.scrollHeight + rowGap) / (rowHeight + rowGap));
    item.style.gridRowEnd = "span " + rowSpan;
  });
}

window.addEventListener('load', resizeGridItems);
window.addEventListener('resize', resizeGridItems);

console.log('Waterfall script loaded');