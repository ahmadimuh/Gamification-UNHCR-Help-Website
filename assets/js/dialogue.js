document.addEventListener('DOMContentLoaded', function () {
  const leftLines = document.querySelectorAll('.speech-left .line');
  const rightLines = document.querySelectorAll('.speech-right .line');

  // اگر هیچ دیالوگی وجود ندارد، کد را اجرا نکن
  if (!leftLines.length && !rightLines.length) return;

  // ابتدا همه دیالوگ‌ها را مخفی نگه داریم
  gsap.set([leftLines, rightLines], {opacity: 0, y: 20});

  // مرحله گفتگو را اجرا کن
  const tl = gsap.timeline();

  tl.to('.speech-left', {opacity: 1, duration: 0.3})
    .to(leftLines, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      stagger: 1
    })
    .to('.speech-right', {opacity: 1, duration: 0.3}, '+=0.5')
    .to(rightLines, {
      opacity: 1,
      y: 0,
      duration: 0.5,
      stagger: 1
    });
});
