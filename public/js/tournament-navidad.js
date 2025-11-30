// resources/js/tournament-navidad.js
document.addEventListener('DOMContentLoaded', () => {
  const container = document.body;
  const createSnow = (count = 16) => {
    for (let i=0;i<count;i++){
      const s = document.createElement('div');
      s.className = 'snowflake';
      s.style.left = Math.random()*100 + '%';
      s.style.fontSize = (8 + Math.random()*18) + 'px';
      s.style.animationDuration = (8 + Math.random()*12) + 's';
      s.style.opacity = 0.6 + Math.random()*0.4;
      s.innerHTML = '❅';
      container.appendChild(s);
      // remove after animation (safe cleanup)
      setTimeout(()=>s.remove(), (parseFloat(s.style.animationDuration)+1)*1000);
    }
  };
  // create initially only when on navidad mode; we'll trigger from blade with a small inline script
  window.createSnow = createSnow;
});
