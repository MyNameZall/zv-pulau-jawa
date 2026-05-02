<?php
require_once 'includes/data.php';

// Load uploaded images mapping
$uploadsJson = 'storage/uploads.json';
$uploadedImages = [];
if (file_exists($uploadsJson)) {
    $uploadedImages = json_decode(file_get_contents($uploadsJson), true) ?: [];
}

// Helper to get image
function getCardImage($key, $uploadedImages) {
    if (isset($uploadedImages[$key])) {
        $path = $uploadedImages[$key];
        // Check if file actually exists on disk
        if (file_exists(__DIR__ . '/' . $path)) {
            return $path;
        }
    }
    return '';
}

include_once 'includes/head.php';
include_once 'includes/navbar.php';
?>

<!-- HERO -->
<section id="hero">
    <div class="hero-sun"></div>
    <div class="hero-clouds">
        <div class="cloud" style="width:180px;height:50px;top:10px;left:5%;animation-duration:35s;animation-delay:-10s;">
            <style>
                .cloud::before {
                    width: 80px;
                    height: 80px;
                    top: -40px;
                    left: 20px;
                }

                .cloud::after {
                    width: 60px;
                    height: 60px;
                    top: -30px;
                    right: 20px;
                }
            </style>
        </div>
        <div class="cloud" style="width:140px;height:40px;top:40px;left:30%;animation-duration:50s;animation-delay:-25s;"></div>
        <div class="cloud" style="width:200px;height:55px;top:15px;left:70%;animation-duration:42s;animation-delay:-5s;"></div>
    </div>
    <div class="hero-content">
        <div class="hero-badge">🌊 Destinasi Terbaik Indonesia</div>
        <h1 class="hero-title">Jelajahi<br><em>Keindahan</em><br>Pulau Jawa</h1>
        <p class="hero-desc">Dari puncak gunung berapi yang megah, pantai pasir putih yang eksotis, hingga budaya
            yang kaya — Jawa menyimpan segalanya untuk Anda.</p>
        <div class="hero-btns">
            <a href="#beaches" class="btn-primary"><i class="fas fa-compass"></i> Mulai Eksplorasi</a>
            <a href="#pantai-lengkap" class="btn-outline">Lihat Semua Pantai</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="stat-n">127+</div>
            <div class="stat-l">Juta Penduduk</div>
        </div>
        <div class="hero-stat">
            <div class="stat-n">6</div>
            <div class="stat-l">Provinsi</div>
        </div>
        <div class="hero-stat">
            <div class="stat-n">300+</div>
            <div class="stat-l">Destinasi Wisata</div>
        </div>
        <div class="hero-stat">
            <div class="stat-n">3</div>
            <div class="stat-l">Situs UNESCO</div>
        </div>
    </div>
    <svg class="hero-waves" viewBox="0 0 1440 160" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,80 C360,160 1080,0 1440,80 L1440,160 L0,160 Z" fill="#FFFDF8" />
    </svg>
</section>

<!-- ══ PULAU & GUNUNG ══ -->
<div id="islands-mountains" class="top-row">
    <!-- ISLANDS -->
    <div class="top-col reveal-right" style="order:2">
        <div class="section-label"><i class="fas fa-island-tropical"></i> Pulau-Pulau Jawa</div>
        <h2 class="section-title">Pulau <span>Eksotis</span><br>di Sekitar Jawa</h2>
        <p class="section-sub">Kepulauan kecil nan memesona yang mengelilingi Pulau Jawa — surga tersembunyi menunggu dijelajahi.</p>
        <div class="island-grid" style="margin-top:1.8rem">
            <?php foreach ($islands as $island): 
                $imgUrl = getCardImage($island['name'], $uploadedImages);
            ?>
                <div class="island-card photo-card">
                    <section class="img" style="height:130px" onclick="triggerUpload(this)" data-key="<?= htmlspecialchars($island['name']) ?>">
                        <img src="<?= $imgUrl ?>" alt="<?= $island['name'] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                        <div class="upload-placeholder" style="<?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera"></i><span>Tambah Foto</span><span style="font-size:0.65rem;opacity:0.6">Klik untuk upload</span></div>
                        <input type="file" accept="image/*" onchange="previewImg(this)">
                    </section>
                    <div class="card-body">
                        <span class="card-tag tag-island">🏝 <?= $island['tag'] ?></span>
                        <div class="card-name"><?= $island['name'] ?></div>
                        <div class="card-loc"><i class="fas fa-map-marker-alt" style="color:var(--coral)"></i> <?= $island['province'] ?></div>
                        <div class="card-desc"><?= $island['desc'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- MOUNTAINS -->
    <div class="top-col reveal-left" style="order:1">
        <div class="section-label"><i class="fas fa-mountain"></i> Pegunungan Jawa</div>
        <h2 class="section-title">Puncak-Puncak <span>Megah</span><br>di Pulau Jawa</h2>
        <p class="section-sub">Gunung-gunung berapi aktif dan non-aktif yang menjadi destinasi trekking kelas dunia.</p>
        <div class="mountain-list" style="margin-top:1.8rem">
            <?php foreach ($mountains as $mountain): 
                $imgUrl = getCardImage($mountain['name'], $uploadedImages);
            ?>
                <div class="mountain-item">
                    <div class="mountain-img-wrap">
                        <section class="img" onclick="triggerUpload(this)" style="height:70px" data-key="<?= htmlspecialchars($mountain['name']) ?>">
                            <img src="<?= $imgUrl ?>" alt="<?= $mountain['name'] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                            <div class="upload-placeholder" style="font-size:0.6rem;gap:0.2rem; <?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera" style="font-size:1rem"></i><span>Foto</span></div>
                            <input type="file" accept="image/*" onchange="previewImg(this)">
                        </section>
                    </div>
                    <div class="mountain-info">
                        <div class="card-name"><?= $mountain['name'] ?></div>
                        <div class="card-loc"><i class="fas fa-map-marker-alt" style="color:var(--coral)"></i> <?= $mountain['province'] ?></div>
                        <div class="card-desc"><?= $mountain['desc'] ?></div>
                    </div>
                    <div class="mountain-elev"><?= $mountain['elev'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ══ WAVE ══ -->
<div class="wave-divider" style="background:#FFFDF8">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#E0F5FF" />
    </svg>
</div>

<!-- ══ PANTAI / BEACHES ══ -->
<section id="beaches" class="section-wrap" style="background:linear-gradient(180deg,#E0F5FF,#F0FBFF)">
    <div class="grid-head reveal">
        <div>
            <div class="section-label"><i class="fas fa-umbrella-beach"></i> Pantai-Pantai Jawa</div>
            <h2 class="section-title">Pantai <span>Terindah</span><br>Pulau Jawa</h2>
            <p class="section-sub">Dari Banten hingga Banyuwangi — setiap pantai memiliki karakter dan keajaiban tersendiri.</p>
        </div>
        <a href="#pantai-lengkap" class="see-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>

    <!-- Filter tags -->
    <div class="pantai-tags reveal">
        <span class="pantai-tag active" onclick="filterPantai('all',this)">Semua</span>
        <span class="pantai-tag" onclick="filterPantai('jawabarat',this)">Jawa Barat</span>
        <span class="pantai-tag" onclick="filterPantai('banten',this)">Banten</span>
        <span class="pantai-tag" onclick="filterPantai('jawatengah',this)">Jawa Tengah</span>
        <span class="pantai-tag" onclick="filterPantai('yogya',this)">DI Yogyakarta</span>
        <span class="pantai-tag" onclick="filterPantai('jawatimur',this)">Jawa Timur</span>
    </div>

    <div class="beaches-grid" id="beachGrid">
        <!-- FEATURED BEACHES -->
        <?php foreach ($beaches_featured as $beach): 
            $imgUrl = getCardImage($beach['name'], $uploadedImages);
        ?>
            <div class="beach-featured photo-card" data-prov="<?= $beach['prov_slug'] ?>">
                <section class="img" style="height:300px" onclick="triggerUpload(this)" data-key="<?= htmlspecialchars($beach['name']) ?>">
                    <img src="<?= $imgUrl ?>" alt="<?= $beach['name'] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                    <div class="upload-placeholder" style="<?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera"></i><span>Tambah Foto Pantai</span><span style="font-size:0.68rem;opacity:0.6">Klik untuk upload gambar Anda</span></div>
                    <input type="file" accept="image/*" onchange="previewImg(this)">
                </section>
                <div class="card-body">
                    <span class="card-tag tag-beach">🌊 Pantai Unggulan</span>
                    <div class="card-name"><?= $beach['name'] ?></div>
                    <div class="card-loc"><i class="fas fa-map-marker-alt" style="color:var(--coral)"></i> <?= $beach['location'] ?>, <?= $beach['province'] ?></div>
                    <div class="card-desc"><?= $beach['desc'] ?></div>
                    <div class="card-footer-row">
                        <div class="card-rating"><i class="fas fa-star"></i> <?= $beach['rating'] ?></div>
                        <button class="card-fav" onclick="toggleFav(this)"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- SMALLER BEACH CARDS -->
        <?php foreach ($beaches_small as $beach): 
            $imgUrl = getCardImage($beach['name'], $uploadedImages);
        ?>
            <div class="photo-card" data-prov="<?= $beach['prov_slug'] ?>">
                <section class="img" style="height:200px" onclick="triggerUpload(this)" data-key="<?= htmlspecialchars($beach['name']) ?>">
                    <img src="<?= $imgUrl ?>" alt="<?= $beach['name'] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                    <div class="upload-placeholder" style="<?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera"></i><span>Tambah Foto</span></div>
                    <input type="file" accept="image/*" onchange="previewImg(this)">
                </section>
                <div class="card-body">
                    <span class="card-tag tag-beach">🌊 Pantai</span>
                    <div class="card-name"><?= $beach['name'] ?></div>
                    <div class="card-loc"><i class="fas fa-map-marker-alt" style="color:var(--coral)"></i> <?= $beach['location'] ?>, <?= $beach['province'] ?></div>
                    <div class="card-desc"><?= $beach['desc'] ?></div>
                    <div class="card-footer-row">
                        <div class="card-rating"><i class="fas fa-star"></i> <?= $beach['rating'] ?></div>
                        <button class="card-fav" onclick="toggleFav(this)"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ══ DAFTAR PANTAI LENGKAP ══ -->
<section id="pantai-lengkap" class="section-wrap">
    <div class="reveal">
        <div class="section-label"><i class="fas fa-list"></i> Direktori Lengkap</div>
        <h2 class="section-title">Daftar <span>Semua Pantai</span><br>di Pulau Jawa</h2>
        <p class="section-sub">Direktori lengkap pantai-pantai terbaik dari 6 provinsi di Pulau Jawa — referensi perjalanan Anda.</p>
    </div>
    <div class="pantai-table-wrap reveal">
        <table class="pantai-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pantai</th>
                    <th>Kota / Kabupaten</th>
                    <th>Provinsi</th>
                    <th>Keunggulan</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pantai_lengkap as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><strong>Pantai <?= $row[0] ?></strong></td>
                        <td><?= $row[1] ?></td>
                        <td><span class="province-badge p-<?= $row[5] ?>"><?= $row[2] ?></span></td>
                        <td><?= $row[3] ?></td>
                        <td class="star-rating"><?= str_repeat('★', floor($row[4])) . (fmod($row[4], 1) >= 0.5 ? '½' : '') . str_repeat('☆', 5 - ceil($row[4])) ?> <?= $row[4] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- HIGHLIGHT STRIP -->
<div class="highlight-strip">
    <div class="strip-text">
        <div class="strip-title">Siap Memulai<br>Petualangan Anda?</div>
        <div class="strip-sub">Ribuan destinasi menakjubkan menunggu — Jawa adalah surga yang nyata.</div>
    </div>
    <button class="strip-btn">🗺 Rencanakan Perjalanan</button>
</div>

<!-- ══ WISATA LAINNYA ══ -->
<section id="wisata" class="section-wrap">
    <div class="grid-head reveal">
        <div>
            <div class="section-label"><i class="fas fa-map-marked-alt"></i> Wisata Lainnya</div>
            <h2 class="section-title">Jelajahi Lebih<br><span>Banyak Destinasi</span></h2>
        </div>
        <a href="#" class="see-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="wisata-grid">
        <?php foreach ($wisata_lain as $item): 
            $imgUrl = getCardImage($item['name'], $uploadedImages);
        ?>
            <div class="wisata-card photo-card reveal">
                <section class="img" style="height:200px" onclick="triggerUpload(this)" data-key="<?= htmlspecialchars($item['name']) ?>">
                    <img src="<?= $imgUrl ?>" alt="<?= $item['name'] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                    <div class="upload-placeholder" style="<?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera"></i><span>Tambah Foto</span></div>
                    <input type="file" accept="image/*" onchange="previewImg(this)">
                </section>
                <div class="card-body">
                    <span class="card-tag tag-<?= strtolower($item['tag']) ?>"><?= $item['tag'] === 'Culture' ? '🏛' : ($item['tag'] === 'Nature' ? '🌿' : '⛰') ?> <?= $item['tag'] ?></span>
                    <div class="card-name"><?= $item['name'] ?></div>
                    <div class="card-loc"><i class="fas fa-map-marker-alt" style="color:var(--coral)"></i> <?= $item['location'] ?>, <?= $item['province'] ?></div>
                    <div class="card-desc"><?= $item['desc'] ?></div>
                    <div class="card-footer-row">
                        <div class="card-rating"><i class="fas fa-star"></i> <?= $item['rating'] ?></div>
                        <button class="card-fav" onclick="toggleFav(this)"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ══ WAVE ══ -->
<div class="wave-divider" style="background:white">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,0 C480,60 960,0 1440,40 L1440,60 L0,60 Z" fill="#FFF8F0" />
    </svg>
</div>

<!-- ══ KULINER ══ -->
<section id="culinary" class="section-wrap" style="background:linear-gradient(135deg,#FFF8F0,#FFE8D0)">
    <div class="reveal">
        <div class="section-label"><i class="fas fa-utensils"></i> Kuliner Khas</div>
        <h2 class="section-title">Cita Rasa <span>Nusantara</span><br>dari Jawa</h2>
        <p class="section-sub">Perjalanan kuliner yang menggoyang lidah — setiap daerah di Jawa punya keistimewaan rasa tersendiri.</p>
    </div>
    <div class="culinary-scroll reveal">
        <?php foreach ($culinary as $food): 
            $imgUrl = getCardImage($food[0], $uploadedImages);
        ?>
            <div class="food-card photo-card">
                <section class="img" style="height:140px" onclick="triggerUpload(this)" data-key="<?= htmlspecialchars($food[0]) ?>">
                    <img src="<?= $imgUrl ?>" alt="<?= $food[0] ?>" style="<?= $imgUrl ? 'display:block;width:100%;height:100%;object-fit:cover;' : 'display:none' ?>">
                    <div class="upload-placeholder" style="<?= $imgUrl ? 'display:none' : '' ?>"><i class="fas fa-camera"></i><span>Tambah Foto</span></div>
                    <input type="file" accept="image/*" onchange="previewImg(this)">
                </section>
                <div class="card-body">
                    <span class="card-tag tag-culture">🍲 Kuliner</span>
                    <div class="card-name"><?= $food[0] ?></div>
                    <div class="card-desc"><?= $food[1] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>
