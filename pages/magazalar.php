<?php
$current_page = 'stores';
?>
<?php

include __DIR__ . '/../includes/navbar.php';
?>
<div class="stores-page">
    <div class="container">
        <div class="stores-header">
            <h1>Dörtyol Mağazaları</h1>
            <p>Dörtyol'un en iyi kampanya ve indirimlerini sunan mağazaları keşfedin.</p>
        </div>

        <!-- Mağaza Filtreleme -->
        <div class="store-filters">
            <div class="search-box">
                <input type="text" placeholder="Mağaza ara...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="filter-buttons">
                <button class="btn btn-outline active">Tümü</button>
                <button class="btn btn-outline">Aktif Kampanyalar</button>
            </div>
        </div>

        <!-- Mağaza Listesi -->
        <div class="stores-grid">
            <!-- Örnek Mağaza Kartı -->
            <div class="store-card" onclick="window.location.href='magaza-detay.php?id=1'">
                <div class="store-image">
                    <img src="https://endecormob.com/tema/genel/uploads/urunler/smaller-2021-02-18T11_23_11.871Z.jpeg"
                        alt="Mağaza Adı">
                    <div class="store-status active">Aktif</div>
                </div>
                <div class="store-info">
                    <div class="store-header">
                        <h2>Örnek Mağaza</h2>
                    </div>
                    <div class="store-owner">
                        <i class="fas fa-user"></i>
                        <span>Ahmet Yılmaz</span>
                    </div>
                    <div class="store-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Dörtyol Merkez, Hatay</span>
                    </div>
                    <div class="store-location">
                        <i class="fas fa-clock"></i>
                        <span>09:00 - 18:00</span>
                    </div>
                    <div class="store-preview" style="display: flex; justify-content: space-between;">
                        <span class="campaign-count">2 Aktif Kampanya</span>
                        <span class="campaign-detail"> <a href="#"
                                style="display: flex; justify-content: space-evenly; align-items: center;"> İncele <i
                                    class="fas fa-arrow-right"></i> </a> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .campaign-detail a {
        text-decoration: underline;
        color: #383E42;
    }

    .stores-page {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .stores-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .stores-header h1 {
        font-size: 2.5rem;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .stores-header p {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    .store-filters {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }

    .store-filters .search-box {
        display: flex;
        gap: 10px;
        max-width: 500px;
        margin: 0 auto;
        width: 100%;
    }

    .store-filters .search-box input {
        flex: 1;
        padding: 12px 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }

    .store-filters .search-box button {
        padding: 12px 20px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .store-filters .search-box button:hover {
        background: var(--primary-dark);
    }

    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .stores-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }

    .store-card {
        background: var(--white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .store-card:hover {
        transform: translateY(-5px);
    }

    .store-image {
        position: relative;
        height: 200px;
    }

    .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .store-status.active {
        background: #28a745;
        color: white;
    }

    .store-info {
        padding: 25px;
    }

    .store-header {
        margin-bottom: 15px;
    }

    .store-header h2 {
        font-size: 1.5rem;
        color: var(--dark);
    }

    .store-owner,
    .store-location {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray);
        margin-bottom: 10px;
    }

    .store-preview {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .campaign-count {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stores-header h1 {
            font-size: 2rem;
        }

        .stores-header p {
            font-size: 1rem;
        }

        .filter-buttons {
            flex-direction: column;
        }

        .filter-buttons .btn {
            width: 100%;
        }

        .stores-grid {
            grid-template-columns: 1fr;
        }
    }
</style>