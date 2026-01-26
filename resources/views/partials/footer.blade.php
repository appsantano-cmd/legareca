<footer class="footer-moving">
    <div class="moving-text">
            C 2026 Santano • Legareca Space • Jl. Legareca No. 123, Jakarta Selatan • (021) 1234-5678 • info@legarecaspace.com • C 2026 Santano • Legareca Space • Jl. Legareca No. 123, Jakarta Selatan • (021) 1234-5678 • info@legarecaspace.com
    </div>
</footer>

<style>
    .footer-moving {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #1f2937;
        color: white;
        padding: 1rem 0;
        overflow: hidden;
        z-index: 100;
    }
    .moving-text {
        display: inline-block;
        white-space: nowrap;
        padding-left: 100%;
        animation: moveText 20s linear infinite;
    }
    @keyframes moveText {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-100%);
    }
}
</style>
