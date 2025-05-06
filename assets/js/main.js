// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', function() {
    // Mobil menü toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Şifre göster/gizle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Şifre gücü kontrolü
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.querySelector('.strength-bar');
            const strengthText = document.querySelector('.strength-text');
            
            if (strengthBar && strengthText) {
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                
                strengthBar.className = 'strength-bar';
                if (strength <= 2) {
                    strengthBar.classList.add('weak');
                    strengthText.textContent = 'Şifre Gücü: Zayıf';
                } else if (strength <= 4) {
                    strengthBar.classList.add('medium');
                    strengthText.textContent = 'Şifre Gücü: Orta';
                } else {
                    strengthBar.classList.add('strong');
                    strengthText.textContent = 'Şifre Gücü: Güçlü';
                }
            }
        });
    }

    // Form doğrulama
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirm"]');
            
            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                e.preventDefault();
                alert('Şifreler eşleşmiyor!');
            }
        });
    });

    // Bildirim sayısı güncelleme
    updateNotificationCount();
});

// Bildirim sayısını güncelle
function updateNotificationCount() {
    fetch('get-notification-count.php')
        .then(response => response.json())
        .then(data => {
            const notificationBadge = document.querySelector('.notification-badge');
            if (notificationBadge) {
                if (data.count > 0) {
                    notificationBadge.textContent = data.count;
                    notificationBadge.style.display = 'block';
                } else {
                    notificationBadge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Bildirim sayısı alınamadı:', error));
}

// Kampanya favorilere ekle/çıkar
function toggleFavorite(campaignId) {
    fetch('toggle-favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ campaign_id: campaignId })
    })
    .then(response => response.json())
    .then(data => {
        const button = document.querySelector(`[data-campaign-id="${campaignId}"]`);
        if (button) {
            if (data.success) {
                button.classList.toggle('active');
                button.querySelector('i').classList.toggle('fas');
                button.querySelector('i').classList.toggle('far');
            }
        }
    })
    .catch(error => console.error('Favori işlemi başarısız:', error));
}

// Mağaza takip et/takibi bırak
function toggleFollow(storeId) {
    fetch('toggle-follow.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ store_id: storeId })
    })
    .then(response => response.json())
    .then(data => {
        const button = document.querySelector(`[data-store-id="${storeId}"]`);
        if (button) {
            if (data.success) {
                button.classList.toggle('active');
                button.querySelector('i').classList.toggle('fas');
                button.querySelector('i').classList.toggle('far');
            }
        }
    })
    .catch(error => console.error('Takip işlemi başarısız:', error));
}

// Kampanya paylaş
function shareCampaign(campaignId) {
    if (navigator.share) {
        const campaign = document.querySelector(`[data-campaign-id="${campaignId}"]`);
        if (campaign) {
            const title = campaign.dataset.title;
            const text = campaign.dataset.description;
            const url = window.location.origin + '/campaign.php?id=' + campaignId;

            navigator.share({
                title: title,
                text: text,
                url: url
            })
            .catch(error => console.error('Paylaşım hatası:', error));
        }
    } else {
        // Web Share API desteklenmiyorsa kopyala
        const url = window.location.origin + '/campaign.php?id=' + campaignId;
        navigator.clipboard.writeText(url)
            .then(() => alert('Kampanya linki kopyalandı!'))
            .catch(error => console.error('Kopyalama hatası:', error));
    }
}

// Harita yönlendirme
function getDirections(latitude, longitude, storeName) {
    const url = `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}&travelmode=driving&destination_place_id=${storeName}`;
    window.open(url, '_blank');
} 