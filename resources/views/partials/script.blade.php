<!-- Script Libraries via CDN -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Local Script Libraries -->
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/embla.js') }}"></script>


<!-- Script Codes -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil elemen carousel berdasarkan ID-nya
        const carouselElement = document.getElementById('carouselExampleControls');

        // Pastikan elemen ditemukan
        if (carouselElement) {
            // Cek apakah MDB telah mendefinisikan class Carousel
            if (typeof mdb !== 'undefined' && mdb.Carousel) {
                // Inisialisasi Carousel MDB secara manual
                const carousel = new mdb.Carousel(carouselElement, {
                    interval: 3000, // Geser setiap 3 detik (opsional, defaultnya 5000)
                    ride: 'carousel' // Pastikan auto-play aktif
                });
            } else {
                // Jika Anda juga memuat Bootstrap 5, coba inisialisasi sebagai Bootstrap biasa (bs)
                if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                    new bootstrap.Carousel(carouselElement, {
                        interval: 3000
                    });
                }
            }
        }
    });
</script>

<script>
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false, // Added to prevent autoplay from stopping on user interaction
        },
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',  
        initialSlide: 2,
        coverflowEffect: {
            rotate: 50,
            stretch: 40,
            depth: 100,
            modifier: 1,
            slideShadows: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }, 
    });

</script> 

{{-- Embla Scripts --}}
<script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const emblaNode = document.querySelector(".embla");
    const viewportNode = emblaNode.querySelector(".embla__viewport");
    const prevBtn = emblaNode.querySelector("#prevBtn");
    const nextBtn = emblaNode.querySelector("#nextBtn");
    const dotsNode = emblaNode.querySelector(".embla__dots");

    // Init Embla
    const emblaApi = EmblaCarousel(viewportNode, { loop: true });

    // === Buttons ===
    prevBtn.addEventListener("click", () => emblaApi.scrollPrev());
    nextBtn.addEventListener("click", () => emblaApi.scrollNext());

    // === Dots ===
    const slides = emblaApi.scrollSnapList();
    const dots = slides.map((_, index) => {
      const button = document.createElement("button");
      button.classList.add("embla__dot");
      dotsNode.appendChild(button);
      button.addEventListener("click", () => emblaApi.scrollTo(index));
      return button;
    });

    const setSelectedDot = () => {
      const selectedIndex = emblaApi.selectedScrollSnap();
      dots.forEach((dot, index) => {
        dot.classList.toggle("embla__dot--selected", index === selectedIndex);
      });
    };

    emblaApi.on("select", setSelectedDot);
    emblaApi.on("reInit", setSelectedDot);
    setSelectedDot();

    // === Autoplay ===
    let autoplay = setInterval(() => {
      emblaApi.scrollNext();
    }, 3000); // ganti angka 3000 → 4 detik

    // (Opsional) Pause autoplay kalau user drag/hover
    emblaApi.on("pointerDown", () => clearInterval(autoplay));
    emblaNode.addEventListener("mouseenter", () => clearInterval(autoplay));
    emblaNode.addEventListener("mouseleave", () => {
      autoplay = setInterval(() => emblaApi.scrollNext(), 3000);
    });
  });
</script>
{{-- Embla Scripts END --}}

{{-- Searchbar Lokasi --}}
<script>
    // Dapatkan elemen input dari search bar
    const searchInput = document.getElementById('search-input');
    
    // Dapatkan semua kartu lokasi
    const locationCards = document.querySelectorAll('.col-lg-4');
    
    // Dapatkan elemen pesan "tidak ada hasil"
    const noResultsMessage = document.getElementById('no-results-message');

    // Tambahkan event listener untuk 'keyup'
    searchInput.addEventListener('keyup', function(event) {
        const searchTerm = event.target.value.toLowerCase();
        let foundResults = false; // Tambahkan flag untuk melacak hasil

        locationCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();

            if (cardText.includes(searchTerm)) {
                card.style.display = '';
                foundResults = true; // Setel flag menjadi true karena ada hasil
            } else {
                card.style.display = 'none';
            }
        });

        // Cek status flag setelah perulangan selesai
        if (foundResults) {
            noResultsMessage.style.display = 'none'; // Sembunyikan pesan jika ada hasil
        } else {
            noResultsMessage.style.display = 'block'; // Tampilkan pesan jika tidak ada hasil
        }
    });
</script>
{{-- Searchbar Lokasi End --}}

{{-- Searchbar Products --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const cards = document.querySelectorAll(".col-lg-3");
    const noResultsMessage = document.getElementById("no-results-message");

    searchInput.addEventListener("keyup", function () {
      const query = this.value.toLowerCase();
      let visibleCount = 0;

      cards.forEach(card => {
        const title = card.querySelector("h3").textContent.toLowerCase();
        const desc = card.querySelector("small").textContent.toLowerCase();

        if (title.includes(query) || desc.includes(query)) {
          card.style.display = "block";
          visibleCount++;
        } else {
          card.style.display = "none";
        }
      });

      // Tampilkan pesan hanya kalau tidak ada hasil
      if (visibleCount === 0) {
        noResultsMessage.style.display = "block";
      } else {
        noResultsMessage.style.display = "none";
      }
    });
  });
</script>

{{-- Searchbar Products End --}}

{{-- CATALOG PDF --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const url = "{{ asset('files/Catalog Groza (July 2025).pdf') }}"; // file lokal di public/files/

        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.2, // default zoom
            canvas = document.getElementById("the-canvas"),
            ctx = canvas.getContext("2d");

        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(function () {
                    pageRendering = false;
                    document.getElementById("page_num").textContent = num;

                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }

        function onZoomIn() {
            scale += 0.2;
            queueRenderPage(pageNum);
        }

        function onZoomOut() {
            if (scale > 0.4) { // batas minimum zoom
                scale -= 0.2;
                queueRenderPage(pageNum);
            }
        }

        document.getElementById("prev").addEventListener("click", onPrevPage);
        document.getElementById("next").addEventListener("click", onNextPage);
        document.getElementById("zoomIn").addEventListener("click", onZoomIn);
        document.getElementById("zoomOut").addEventListener("click", onZoomOut);

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById("page_count").textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });
    });
</script>
{{-- CATALOG PDF END --}}

{{-- ARTIKEL --}}
<script>
// Ambil elemen artikel
const article = document.getElementById('article');
const text = article.querySelector('.article-info').innerText;

// Tentukan jumlah kata per paragraf
const wordsPerParagraph = 91;

// Bagi teks menjadi array kata
const words = text.split(' ');

// Buat array baru untuk paragraf
let paragraphs = [];
for (let i = 0; i < words.length; i += wordsPerParagraph) {
    paragraphs.push(words.slice(i, i + wordsPerParagraph).join(' '));
}

// Hapus teks lama
article.innerHTML = '';

// Tambahkan setiap paragraf baru
paragraphs.forEach(pText => {
    const p = document.createElement('p');
    p.classList.add('article-info');
    p.innerText = pText;
    article.appendChild(p);
});
</script>
{{-- ARTIKEL END --}}

{{-- WA START --}}
<script>
document.getElementById('waForm').addEventListener('submit', function(e) {
  e.preventDefault();

  let namaToko   = document.getElementById('nama_toko').value;
  let namaOwner  = document.getElementById('nama_owner').value;
  let alamatToko = document.getElementById('alamat_toko').value;
  let provinsi   = document.getElementById('provinsi').value;
  let telepon    = document.getElementById('telepon').value;

  let message = `Halo Admin, saya ingin mengajukan kemitraan dengan Groza:\n\n` +
                `🏪 Nama Toko: ${namaToko}\n` +
                `👤 Nama Owner: ${namaOwner}\n` +
                `📍 Alamat Toko: ${alamatToko}\n` +
                `🌏 Provinsi: ${provinsi}\n` +
                `📞 Telepon: ${telepon}`;

  let phone = "6283119800260";

  // cek device
  if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
      // Mobile → buka aplikasi WA
      window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
  } else {
      // Desktop → buka WA Web
      window.open(`https://web.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(message)}`, '_blank');
  }
});
</script>
{{-- WA END --}}






<!-- Scripts Codes n Libraries End -->



