<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.querySelector('.mobile-menu-btn');
    const menu = document.querySelector('.nav-menu');

    console.log('BTN:', btn);
    console.log('MENU:', menu);

    if (!btn || !menu) return;

    btn.addEventListener('click', function () {
        console.log('CLICK');
        menu.classList.toggle('hidden');
    });
});
</script>
