// Main JavaScript

document.addEventListener("DOMContentLoaded", () => {
  // --- Title Hover Effect (Follow Mouse) ---
  // Target all heading tags as requested
  const headings = document.querySelectorAll(
    "h1, h2, h3, h4, h5, h6, .title-hover-effect",
  );

  headings.forEach((title) => {
    // Avoid duplicate effect if a parent header contains a child with the effect
    if (
      title.tagName.match(/^H[1-6]$/) &&
      title.querySelector(".title-hover-effect")
    ) {
      return;
    }

    // Ensure the class is present for styling
    title.classList.add("title-hover-effect");

    // Check if circle already exists (avoid duplicates if re-run)
    if (!title.querySelector(".cursor-circle")) {
      const circle = document.createElement("span");
      circle.classList.add("cursor-circle");
      title.appendChild(circle);
    }

    const circle = title.querySelector(".cursor-circle");

    title.addEventListener("mousemove", (e) => {
      const rect = title.getBoundingClientRect();

      // Calculate position
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      circle.style.left = `${x}px`;
      circle.style.top = `${y}px`;
    });
  });

  // --- Our News Digest Scroll ---
  const scrollContainer = document.getElementById("ourDigestScroll");
  const btnLeft = document.getElementById("ourScrollLeft");
  const btnRight = document.getElementById("ourScrollRight");

  if (scrollContainer && btnLeft && btnRight) {
    // --- Infinite Scroll Setup ---
    // Clone all cards to create the loop
    const cards = Array.from(scrollContainer.children);
    cards.forEach((card) => {
      const clone = card.cloneNode(true);
      scrollContainer.appendChild(clone);
    });

    // -- Manual Scroll --
    btnLeft.addEventListener("click", () => {
      scrollContainer.scrollBy({ left: -310, behavior: "smooth" }); // Card width + gap
    });

    btnRight.addEventListener("click", () => {
      scrollContainer.scrollBy({ left: 310, behavior: "smooth" });
    });

    // -- Auto Scroll --
    let scrollSpeed = 1; // Pixels per interval (User requested speed)
    let isHovered = false;

    // Pause on hover (Container)
    scrollContainer.addEventListener("mouseenter", () => {
      isHovered = true;
    });
    scrollContainer.addEventListener("mouseleave", () => {
      isHovered = false;
    });

    // Pause on hover (Buttons)
    btnLeft.addEventListener("mouseenter", () => {
      isHovered = true;
    });
    btnLeft.addEventListener("mouseleave", () => {
      isHovered = false;
    });
    btnRight.addEventListener("mouseenter", () => {
      isHovered = true;
    });
    btnRight.addEventListener("mouseleave", () => {
      isHovered = false;
    });

    // Auto-scroll loop
    setInterval(() => {
      if (!isHovered) {
        scrollContainer.scrollLeft += scrollSpeed;

        // Infinite Loop Check
        // Note: We cloned the content, so scrollWidth matches 2x the original content.
        // When we reach halfway (the start of the clones), we jump back to 0.
        // We use a slight buffer or specific check.
        // The most robust way is checking if we've scrolled past the first half.
        if (scrollContainer.scrollLeft >= scrollContainer.scrollWidth / 2) {
          // Instantly jump back to start (minus the overshoot amount to be precise)
          // scrollContainer.scrollLeft = 0;
          // To be silky smooth precise:
          scrollContainer.scrollLeft =
            scrollContainer.scrollLeft - scrollContainer.scrollWidth / 2;
        }
      }
    }, 20); // ~50fps
  }

  // --- Podcasts Scroll (Duplicate Logic) ---
  const podcastScrollContainer = document.getElementById("podcastScroll");
  const podcastBtnLeft = document.getElementById("podcastScrollLeft");
  const podcastBtnRight = document.getElementById("podcastScrollRight");

  if (podcastScrollContainer && podcastBtnLeft && podcastBtnRight) {
    // Clone cards
    const pCards = Array.from(podcastScrollContainer.children);
    pCards.forEach((card) => {
      const clone = card.cloneNode(true);
      podcastScrollContainer.appendChild(clone);
    });

    // Manual Scroll
    podcastBtnLeft.addEventListener("click", () => {
      podcastScrollContainer.scrollBy({ left: -340, behavior: "smooth" }); // Card width + gap approx
    });

    podcastBtnRight.addEventListener("click", () => {
      podcastScrollContainer.scrollBy({ left: 340, behavior: "smooth" });
    });

    // Auto Scroll
    let pScrollSpeed = 0.5; // Slower for podcasts? Or same 1
    let pIsHovered = false;

    podcastScrollContainer.addEventListener("mouseenter", () => {
      pIsHovered = true;
    });
    podcastScrollContainer.addEventListener("mouseleave", () => {
      pIsHovered = false;
    });
    podcastBtnLeft.addEventListener("mouseenter", () => {
      pIsHovered = true;
    });
    podcastBtnLeft.addEventListener("mouseleave", () => {
      pIsHovered = false;
    });
    podcastBtnRight.addEventListener("mouseenter", () => {
      pIsHovered = true;
    });
    podcastBtnRight.addEventListener("mouseleave", () => {
      pIsHovered = false;
    });

    setInterval(() => {
      if (!pIsHovered) {
        podcastScrollContainer.scrollLeft += pScrollSpeed;
        if (
          podcastScrollContainer.scrollLeft >=
          podcastScrollContainer.scrollWidth / 2
        ) {
          podcastScrollContainer.scrollLeft =
            podcastScrollContainer.scrollLeft -
            podcastScrollContainer.scrollWidth / 2;
        }
      }
    }, 20);
  }

  // --- Sticky Header Scroll Effect ---
  const header = document.querySelector(".site-header");
  if (header) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 50) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  // --- Photo Essay Carousel Logic (Infinite Loop) ---
  const essayTabs = document.querySelectorAll("#photoEssayTabs .strategy-tab");
  const essayScroll = document.getElementById("photoEssayScroll");
  const originalSlides = document.querySelectorAll(".photo-essay-slide");
  const btnPrev = document.getElementById("essayPrev");
  const btnNext = document.getElementById("essayNext");

  if (essayScroll && essayTabs.length > 0 && originalSlides.length > 0) {
    // --- Slide Cloning ---
    const firstSlide = originalSlides[0];
    const lastSlide = originalSlides[originalSlides.length - 1];

    const cloneFirst = firstSlide.cloneNode(true);
    const cloneLast = lastSlide.cloneNode(true);

    cloneFirst.classList.add("clone-slide");
    cloneLast.classList.add("clone-slide");

    essayScroll.appendChild(cloneFirst);
    essayScroll.insertBefore(cloneLast, firstSlide);

    const allSlides = document.querySelectorAll(".photo-essay-slide");
    const slideCount = originalSlides.length;

    // Helper: Scroll to specific slide
    const scrollToSlide = (index, behavior = "smooth") => {
      const slide = allSlides[index];
      if (!slide) return;

      const containerWidth = essayScroll.offsetWidth;
      const slideWidth = slide.offsetWidth;

      // Center alignment math
      const scrollPos = slide.offsetLeft - containerWidth / 2 + slideWidth / 2;

      essayScroll.scrollTo({
        left: scrollPos,
        behavior: behavior,
      });
    };

    // Helper: Determine current index based on scroll
    const getUrlActiveIndex = () => {
      const containerWidth = essayScroll.offsetWidth;
      const scrollCenter = essayScroll.scrollLeft + containerWidth / 2;

      let closest = 0;
      let minDiff = Infinity;

      allSlides.forEach((slide, index) => {
        const slideCenter = slide.offsetLeft + slide.offsetWidth / 2;
        const diff = Math.abs(scrollCenter - slideCenter);
        if (diff < minDiff) {
          minDiff = diff;
          closest = index;
        }
      });
      return closest;
    };

    // Update UI State
    const updateActiveState = () => {
      const activeIndex = getUrlActiveIndex();

      // Highlight Function
      const highlightStats = (idx) => {
        allSlides.forEach((s) => s.classList.remove("active-slide"));
        if (allSlides[idx]) allSlides[idx].classList.add("active-slide");

        // Map to Tab
        let tabIdx = -1;
        if (idx === 0) tabIdx = slideCount - 1;
        else if (idx === slideCount + 1) tabIdx = 0;
        else tabIdx = idx - 1;

        essayTabs.forEach((t) => t.classList.remove("active"));
        if (essayTabs[tabIdx]) {
          essayTabs[tabIdx].classList.add("active");
          // Scroll active tab into view on mobile
          if (window.innerWidth < 992) {
            const tabContainer = document.getElementById("photoEssayTabs");
            const activeTab = essayTabs[tabIdx].parentElement; // The col wrapper
            const containerWidth = tabContainer.offsetWidth;
            const tabOffsetLeft = activeTab.offsetLeft;
            const tabWidth = activeTab.offsetWidth;

            tabContainer.scrollTo({
              left: tabOffsetLeft - containerWidth / 2 + tabWidth / 2,
              behavior: "smooth",
            });
          }
        }
      };

      highlightStats(activeIndex);

      // Infinite Loop Jump (Silent)
      if (activeIndex === 0) {
        setTimeout(() => scrollToSlide(slideCount, "auto"), 300);
      } else if (activeIndex === slideCount + 1) {
        setTimeout(() => scrollToSlide(1, "auto"), 300);
      }
    };

    // Initialize
    setTimeout(() => {
      scrollToSlide(1, "auto");
      updateActiveState();
    }, 100);

    // Arrows (Slides)
    if (btnPrev)
      btnPrev.addEventListener("click", () =>
        scrollToSlide(getUrlActiveIndex() - 1, "smooth"),
      );
    if (btnNext)
      btnNext.addEventListener("click", () =>
        scrollToSlide(getUrlActiveIndex() + 1, "smooth"),
      );

    // Tabs
    essayTabs.forEach((tab, index) => {
      tab.addEventListener("click", () => {
        scrollToSlide(index + 1, "smooth");
      });
    });

    // Scroll Logic for Slides
    let isScrolling;
    essayScroll.addEventListener("scroll", () => {
      window.clearTimeout(isScrolling);
      isScrolling = setTimeout(updateActiveState, 50);
    });
  }

  // --- Sticky Sidebar share and copy functions ---
  window.shareNews = (platform) => {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    let shareUrl = "";

    switch (platform) {
      case "facebook":
        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        break;
      case "x":
        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
        break;
      case "whatsapp":
        shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
        break;
      case "telegram":
        shareUrl = `https://t.me/share/url?url=${url}&text=${title}`;
        break;
      case "linkedin":
        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
        break;
      case "instagram":
        alert("Please share manually on Instagram.");
        return;
    }

    if (shareUrl) {
      window.open(shareUrl, "_blank", "width=600,height=400");
    }
  };

  window.copyNewsLink = () => {
    const url = window.location.href;
    navigator.clipboard
      .writeText(url)
      .then(() => {
        const toaster = document.getElementById("copyToaster");
        if (toaster) {
          toaster.classList.add("show");
          setTimeout(() => {
            toaster.classList.remove("show");
          }, 3000);
        }
      })
      .catch((err) => {
        console.error("Failed to copy: ", err);
      });
  };

  // --- Related Reading Slider ---
  const relatedScrollContainer = document.querySelector(".related-reading-slider-container");
  const relatedWrapper = document.getElementById("relatedReadingSlider");
  const relatedBtnLeft = document.getElementById("relatedPrev");
  const relatedBtnRight = document.getElementById("relatedNext");

  if (relatedScrollContainer && relatedWrapper && relatedBtnLeft && relatedBtnRight) {
    // Clone items for infinite scroll
    const items = Array.from(relatedWrapper.children);
    items.forEach((item) => {
      const clone = item.cloneNode(true);
      relatedWrapper.appendChild(clone);
    });

    // Manual Scroll (Slide by 1 item) with infinite jump logic
    relatedBtnLeft.addEventListener("click", () => {
      if (relatedScrollContainer.scrollLeft <= 5) {
        // Jump to the second half silently
        relatedScrollContainer.scrollLeft = relatedWrapper.scrollWidth / 2;
      }
      relatedScrollContainer.scrollBy({ left: -(relatedScrollContainer.offsetWidth / 2 + 15), behavior: "smooth" });
    });

    relatedBtnRight.addEventListener("click", () => {
      if (relatedScrollContainer.scrollLeft >= (relatedWrapper.scrollWidth / 2) - 5) {
        // Jump to the first half silently
        relatedScrollContainer.scrollLeft = 0;
      }
      relatedScrollContainer.scrollBy({ left: (relatedScrollContainer.offsetWidth / 2 + 15), behavior: "smooth" });
    });

    // Auto Scroll
    let relatedScrollSpeed = 0.8;
    let relatedIsHovered = false;

    const pause = () => { relatedIsHovered = true; };
    const resume = () => { relatedIsHovered = false; };

    relatedScrollContainer.addEventListener("mouseenter", pause);
    relatedScrollContainer.addEventListener("mouseleave", resume);
    relatedBtnLeft.addEventListener("mouseenter", pause);
    relatedBtnLeft.addEventListener("mouseleave", resume);
    relatedBtnRight.addEventListener("mouseenter", pause);
    relatedBtnRight.addEventListener("mouseleave", resume);

    setInterval(() => {
      if (!relatedIsHovered) {
        relatedScrollContainer.scrollLeft += relatedScrollSpeed;
        if (relatedScrollContainer.scrollLeft >= relatedWrapper.scrollWidth / 2) {
          relatedScrollContainer.scrollLeft -= relatedWrapper.scrollWidth / 2;
        }
      }
    }, 20);
  }

  // --- Podcast Premium Audio Player ---
  const audio = document.getElementById("podcastAudio");
  const playPauseBtn = document.getElementById("btnPlayPause");
  const playIcon = document.getElementById("playIcon");
  const timeline = document.getElementById("audioTimeline");
  const currentTimeLabel = document.getElementById("currentTime");
  const totalDurationLabel = document.getElementById("totalDuration");
  const muteBtn = document.getElementById("btnMuteToggle");
  const volumeIcon = document.getElementById("volumeIcon");
  const volumeBar = document.getElementById("volumeBar");
  const speedBtn = document.getElementById("audioSpeedBtn");
  const skipForwardBtn = document.getElementById("btnSkipForward");
  const skipBackBtn = document.getElementById("btnSkipBack");

  if (audio) {
    // Helper function to format time (e.g. 02:45)
    const formatTime = (seconds) => {
      if (isNaN(seconds)) return "00:00";
      const mins = Math.floor(seconds / 60);
      const secs = Math.floor(seconds % 60);
      return `${mins.toString().padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;
    };

    // Update duration label once metadata loads
    audio.addEventListener("loadedmetadata", () => {
      totalDurationLabel.textContent = formatTime(audio.duration);
    });

    // Fallback if metadata is already loaded
    if (audio.readyState >= 1) {
      totalDurationLabel.textContent = formatTime(audio.duration);
    }

    // Play/Pause toggle
    const togglePlay = () => {
      if (audio.paused) {
        audio.play();
        playIcon.classList.remove("fa-play");
        playIcon.classList.add("fa-pause");
      } else {
        audio.pause();
        playIcon.classList.remove("fa-pause");
        playIcon.classList.add("fa-play");
      }
    };

    playPauseBtn.addEventListener("click", togglePlay);

    // Audio progress updates timeline range
    audio.addEventListener("timeupdate", () => {
      const percentage = (audio.currentTime / audio.duration) * 100;
      timeline.value = percentage || 0;
      currentTimeLabel.textContent = formatTime(audio.currentTime);
      
      // Update background track fill dynamically for visual feedback
      timeline.style.background = `linear-gradient(to right, #198754 0%, #198754 ${percentage}%, rgba(255,255,255,0.15) ${percentage}%, rgba(255,255,255,0.15) 100%)`;
    });

    // Seeking on timeline interaction
    const setTimeline = () => {
      const time = (timeline.value / 100) * audio.duration;
      audio.currentTime = time;
    };

    timeline.addEventListener("input", setTimeline);
    timeline.addEventListener("change", setTimeline);

    // Volume Adjustment
    volumeBar.addEventListener("input", () => {
      audio.volume = volumeBar.value;
      audio.muted = false;
      updateVolumeIcon(audio.volume);
    });

    // Mute/Unmute toggle
    muteBtn.addEventListener("click", () => {
      audio.muted = !audio.muted;
      if (audio.muted) {
        volumeIcon.className = "fas fa-volume-xmark";
        volumeBar.value = 0;
      } else {
        volumeBar.value = audio.volume;
        updateVolumeIcon(audio.volume);
      }
    });

    const updateVolumeIcon = (val) => {
      if (val === 0) {
        volumeIcon.className = "fas fa-volume-xmark";
      } else if (val < 0.5) {
        volumeIcon.className = "fas fa-volume-low";
      } else {
        volumeIcon.className = "fas fa-volume-high";
      }
    };

    // Speed adjustment (1.0x -> 1.25x -> 1.5x -> 2.0x)
    const speeds = [1.0, 1.25, 1.5, 2.0];
    let currentSpeedIndex = 0;
    speedBtn.addEventListener("click", () => {
      currentSpeedIndex = (currentSpeedIndex + 1) % speeds.length;
      const speed = speeds[currentSpeedIndex];
      audio.playbackRate = speed;
      speedBtn.textContent = `${speed.toFixed(1)}x`;
    });

    // Skip controls (Forward/Back 10 seconds)
    skipForwardBtn.addEventListener("click", () => {
      audio.currentTime = Math.min(audio.currentTime + 10, audio.duration);
    });

    skipBackBtn.addEventListener("click", () => {
      audio.currentTime = Math.max(audio.currentTime - 10, 0);
    });
  }

  // --- Collapsible Transcript Accordion ---
  const toggleTranscriptBtn = document.getElementById("btnToggleTranscript");
  const transcriptChevron = document.getElementById("transcriptChevron");
  const transcriptBody = document.getElementById("transcriptBody");

  if (toggleTranscriptBtn && transcriptBody) {
    toggleTranscriptBtn.addEventListener("click", () => {
      if (transcriptBody.classList.contains("d-none")) {
        transcriptBody.classList.remove("d-none");
        transcriptChevron.classList.remove("fa-chevron-down");
        transcriptChevron.classList.add("fa-chevron-up");
      } else {
        transcriptBody.classList.add("d-none");
        transcriptChevron.classList.remove("fa-chevron-up");
        transcriptChevron.classList.add("fa-chevron-down");
      }
    });
  }
});
