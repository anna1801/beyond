/**
 * Video Gallery Pagination
 * Handles client-side pagination for videos.html
 */

document.addEventListener("DOMContentLoaded", () => {
    const videosPerPage = 9;
    const videoGrid = document.getElementById("videoGrid");
    const paginationNav = document.getElementById("paginationNav");
    
    if (!videoGrid || !paginationNav) return;

    const videoCards = Array.from(videoGrid.getElementsByClassName("col-lg-4"));
    const totalPages = Math.ceil(videoCards.length / videosPerPage);
    let currentPage = 1;

    function showPage(page) {
        currentPage = page;
        
        // Calculate start and end indices
        const start = (page - 1) * videosPerPage;
        const end = start + videosPerPage;

        // Toggle visibility of video cards
        videoCards.forEach((card, index) => {
            if (index >= start && index < end) {
                card.style.display = "block";
                // Trigger an entrance animation if desired
                card.style.opacity = "0";
                setTimeout(() => {
                    card.style.transition = "opacity 0.4s ease";
                    card.style.opacity = "1";
                }, 50);
            } else {
                card.style.display = "none";
            }
        });

        updatePaginationUI();
        
        // Scroll to top of gallery section for better UX
        const gallerySection = document.querySelector(".video-gallery-section");
        if (gallerySection) {
            window.scrollTo({
                top: gallerySection.offsetTop - 100,
                behavior: 'smooth'
            });
        }
    }

    function updatePaginationUI() {
        paginationNav.innerHTML = "";

        // Previous Button
        const prevLi = document.createElement("li");
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Previous"><i class="fas fa-chevron-left"></i></a>`;
        if (currentPage !== 1) {
            prevLi.addEventListener("click", () => showPage(currentPage - 1));
        }
        paginationNav.appendChild(prevLi);

        // Page Numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement("li");
            pageLi.className = `page-item ${currentPage === i ? 'active' : ''}`;
            pageLi.innerHTML = `<a class="page-link" href="javascript:void(0)">${i}</a>`;
            pageLi.addEventListener("click", () => showPage(i));
            paginationNav.appendChild(pageLi);
        }

        // Next Button
        const nextLi = document.createElement("li");
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)" aria-label="Next"><i class="fas fa-chevron-right"></i></a>`;
        if (currentPage !== totalPages) {
            nextLi.addEventListener("click", () => showPage(currentPage + 1));
        }
        paginationNav.appendChild(nextLi);
    }

    // Initialize - show first page
    if (videoCards.length > videosPerPage) {
        showPage(1);
    } else {
        // If items are less than per page, hide pagination nav
        paginationNav.parentElement.style.display = "none";
    }
});
