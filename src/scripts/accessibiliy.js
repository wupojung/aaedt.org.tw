// 以下是 card component 的无障碍点击支持代码
const cards = document.querySelectorAll('.card');  
Array.prototype.forEach.call(cards, card => {  
    let down, up, link = card.querySelector('h3 a');
    card.style.cursor = 'pointer';  
    card.onmousedown = () => down = +new Date();
    card.onmouseup = () => {
        up = +new Date();
        if ((up - down) < 200) {
            link.click();
        }
    }
});
