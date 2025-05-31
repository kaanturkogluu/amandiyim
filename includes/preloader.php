<div class="custom-preloader">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
            <defs>
                <linearGradient id="gradient-primary" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#6a11cb" />
                    <stop offset="100%" stop-color="#2575fc" />
                </linearGradient>
                <linearGradient id="gradient-secondary" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ff0844" />
                    <stop offset="100%" stop-color="#ffb199" />
                </linearGradient>
            </defs>

            <!-- Ana çember -->
            <circle cx="100" cy="100" r="70" fill="none" stroke="#8e44ad" stroke-width="4" stroke-dasharray="440"
                stroke-dashoffset="440">
                <animate attributeName="stroke-dashoffset" from="440" to="0" dur="2s" repeatCount="indefinite"
                    fill="freeze" calcMode="linear" />
            </circle>

            <!-- İç çember (dönen) -->
            <circle cx="100" cy="100" r="50" fill="none" stroke="url(#gradient-primary)" stroke-width="8">
                <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="3s"
                    repeatCount="indefinite" />
            </circle>

            <!-- Pulsing accent renk noktası -->
            <circle cx="100" cy="100" r="10" fill="#f1c40f">
                <animate attributeName="r" values="10;15;10" dur="1.5s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="1;0.7;1" dur="1.5s" repeatCount="indefinite" />
            </circle>

            <!-- Dönen renkli parçalar -->
            <g>
                <circle cx="100" cy="30" r="8" fill="#3498db">
                    <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="2s"
                        repeatCount="indefinite" />
                </circle>

                <circle cx="100" cy="30" r="8" fill="#e74c3c">
                    <animateTransform attributeName="transform" type="rotate" from="120 100 100" to="480 100 100"
                        dur="2s" repeatCount="indefinite" />
                </circle>

                <circle cx="100" cy="30" r="8" fill="#2ecc71">
                    <animateTransform attributeName="transform" type="rotate" from="240 100 100" to="600 100 100"
                        dur="2s" repeatCount="indefinite" />
                </circle>
            </g>
        </svg>
    </svg>
    <div class="custom-preloader-text">Yükleniyor...</div>
</div>

<style>
    .custom-preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--white);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .custom-preloader svg {
        width: 100px;
        height: 100px;
    }

    .custom-preloader-text {
        margin-top: 20px;
        color: var(--primary);
        font-weight: bold;
        letter-spacing: 2px;
    }

    .custom-preloader.hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>
<script>
     function showPreloader() {
        const preloader = document.querySelector('.custom-preloader');
        if (preloader) {
            preloader.classList.remove('hidden');
        }
    }

    function hidePreloader() {
        const preloader = document.querySelector('.custom-preloader');
        if (preloader) {
            preloader.classList.add('hidden');
        }
    }
</script>