document.addEventListener("DOMContentLoaded", function () {
  // jQuery initialization - check if jQuery is available
  if (typeof $ !== "undefined") {
    const initSelectpicker = () => {
      if (typeof $.fn.selectpicker !== "function") return;
      const $targets = $(
        ".single-product .variations select, .variations_form select, select.selectpicker, .gform_wrapper select, .gform_wrapper .gfield select, .gform_wrapper .gfield_select select"
      ).not(".select2-hidden-accessible");

      // Initialize or refresh
      $targets.each(function () {
        const $el = $(this);
        if ($el.data("selectpicker")) {
          $el.selectpicker("refresh");
        } else {
          $el.selectpicker({ style: "btn-light", dropupAuto: true, width: "100%" });
        }
      });
    };

    // Initial init
    initSelectpicker();

    // Re-init after Gravity Forms render (including AJAX/pagination)
    $(document).on("gform_post_render", function () {
      initSelectpicker();
    });

    // Re-init on GF field added dynamically (e.g., conditional logic)
    $(document).on("gform_field_added", function () {
      initSelectpicker();
    });

    // WooCommerce variation form events
    $(document).on(
      "wc_variation_form woocommerce_variation_has_changed found_variation reset_data updated_wc_div wc_fragments_loaded",
      function () {
        initSelectpicker();
      }
    );
  }

  /* Header on scroll */

  const masthead = document.getElementById("masthead");

  window.addEventListener("scroll", function () {
    if (window.scrollY > 200) {
      masthead.classList.add("on-scroll");
    } else {
      masthead.classList.remove("on-scroll");
    }
  });

  /* Header scroll */

  var headerSwiperContainer = document.querySelector(
    "#masthead .content-scroll-swiper"
  );

  if (headerSwiperContainer) {
    var contentScrollSwiper = new Swiper(headerSwiperContainer, {
      direction: "vertical",
      slidesPerView: "auto",
      freeMode: true,
      scrollbar: {
        el: "#masthead .content-scroll-swiper .swiper-scrollbar",
      },

      mousewheel: true,
    });
  }

  /* If single servive page we add additional class name for body tag */

  if (document.querySelector(".single-services")) {
    document.body.classList.add("single-service-page");
  }

  /* If blog page e we add additional class name for body tag */

  if (
    document.querySelector(".page-header") &&
    document.querySelector(".posts-grid")
  ) {
    document.body.classList.add("blog-page");
  }

  /* Mobile toggle btn */

  document
    .querySelector("#masthead .menu-toggle")
    .addEventListener("click", function (e) {
      document.documentElement.classList.toggle("mobile-nav-open");
      this.classList.toggle("opened");

      e.preventDefault();
    });

  /* Hero swiper */

  document.querySelectorAll(".hero-swiper .swiper-holder").forEach((holder) => {
    const swiperContainer = holder.querySelector(".swiper");

    if (swiperContainer) {
      new Swiper(swiperContainer, {
        slidesPerView: 1,
        spaceBetween: 20,
        autoHeight: true,
        loop: false,
        pagination: {
          el: holder.querySelector(".swiper-pagination"),
          clickable: true,
        },
      });
    }
  });

  /* Product items swiper */

  document.querySelectorAll(".products-swiper").forEach((holder) => {
    const swiperContainer = holder.querySelector(".swiper");

    if (swiperContainer) {
      new Swiper(swiperContainer, {
        slidesPerView: 5,
        spaceBetween: 20,
        loop: false,
        navigation: {
          nextEl: holder.querySelector(".swiper-button-next"),
          prevEl: holder.querySelector(".swiper-button-prev"),
        },

        pagination: {
          el: holder.querySelector(".swiper-pagination"),
          type: "progressbar",
        },

        breakpoints: {
          0: {
            slidesPerView: 1.2,
          },

          576: {
            slidesPerView: 1.5,
          },

          650: {
            slidesPerView: 2.1,
          },

          830: {
            slidesPerView: 3,
            spaceBetween: 30,
          },

          1200: {
            slidesPerView: 4,
            spaceBetween: 40,
          },

          1400: {
            slidesPerView: 5,
            spaceBetween: 65,
          },
        },
      });
    }
  });

  /* Brands items swiper */

  document.querySelectorAll(".brands-swiper").forEach((holder) => {
    const swiperContainer = holder.querySelector(".swiper");

    if (swiperContainer) {
      new Swiper(swiperContainer, {
        slidesPerView: 9,
        spaceBetween: 16,
        loop: false,

        grid: {
          rows: 2,
          fill: "row", // Fill horizontally first
        },

        navigation: {
          nextEl: holder.querySelector(".swiper-button-next"),
          prevEl: holder.querySelector(".swiper-button-prev"),
        },

        pagination: {
          el: holder.querySelector(".swiper-pagination"),
          clickable: true,
        },

        breakpoints: {
          0: {
            slidesPerView: 2,
            grid: {
              rows: 2,
            },
          },
          576: {
            slidesPerView: 3,
            grid: {
              rows: 2,
            },
          },
          650: {
            slidesPerView: 3.5,
            grid: {
              rows: 2,
            },
          },
          830: {
            slidesPerView: 4,
            grid: {
              rows: 2,
            },
          },
          992: {
            slidesPerView: 4,
            grid: {
              rows: 2,
            },
          },
          1200: {
            slidesPerView: 6,
            grid: {
              rows: 2,
            },
          },
          1400: {
            slidesPerView: 9,
            grid: {
              rows: 2,
            },
          },
        },
      });
    }
  });

  /* Products list view switch */

  const viewKey = "productViewMode";
  const buttons = document.querySelectorAll(".view-switcher button");

  // Restore saved view from localStorage on page load
  const savedView = localStorage.getItem(viewKey);
  if (savedView) {
    updateView(savedView);
  }

  // Event listener to update view and save to localStorage
  if (buttons.length > 0) {
    buttons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const view = this.dataset.view;
        localStorage.setItem(viewKey, view);
        updateView(view);
      });
    });
  }

  function updateView(view) {
    // Update active state on buttons
    document.querySelectorAll(".view-switcher button").forEach((btn) => {
      btn.classList.toggle("active", btn.dataset.view === view);
    });

    // Update .products-list
    document.querySelectorAll(".products-list").forEach((list) => {
      list.classList.remove("grid-view", "list-view");
      list.classList.add(view);
    });

    // Update .product-list
    document.querySelectorAll(".product-list").forEach((list) => {
      if (view === "list-view") {
        list.classList.remove("grid-4");
        list.classList.add("list-view");
      } else if (view === "grid-view") {
        list.classList.remove("list-view");
        list.classList.add("grid-4");
      }
    });
  }

  /* Product quantity controls are handled below via event delegation
     to avoid duplicate bindings and work with dynamic content. */

  /* Cart: auto-update on manual input */
  const cartFormEl = document.querySelector("form.woocommerce-cart-form");
  if (cartFormEl) {
    const qtyInputs = cartFormEl.querySelectorAll(
      ".quantity input.qty, .quantity input[type='number']"
    );

    qtyInputs.forEach((input) => {
      let debounce;

      // Initial autosize
      const fitWidth = () => {
        const ch = Math.max(String(input.value || "1").length, 2);
        input.style.width = ch + 1 + "ch";
      };
      fitWidth();

      const triggerUpdate = (immediate = false) => {
        clearTimeout(debounce);
        const exec = () => {
          const updateBtn = cartFormEl.querySelector(
            "button[name='update_cart']"
          );
          if (updateBtn) {
            updateBtn.click();
          } else {
            cartFormEl.submit();
          }
        };
        if (immediate) exec();
        else debounce = setTimeout(exec, 500);
      };

      const normalizeValue = () => {
        let value = parseFloat(input.value);
        const min = parseFloat(input.getAttribute("min"));
        const maxAttr = input.getAttribute("max");
        const max =
          maxAttr === null || maxAttr === "" ? Infinity : parseFloat(maxAttr);

        if (isNaN(value)) return false; // wait until valid number

        if (!isNaN(min)) value = Math.max(min, value);
        if (isFinite(max)) value = Math.min(max, value);
        input.value = String(value);
        fitWidth();
        return true;
      };

      input.addEventListener("input", () => {
        if (!normalizeValue()) return; // don't update yet if invalid
        input.dispatchEvent(new Event("change", { bubbles: true }));
        triggerUpdate(false);
      });

      input.addEventListener("change", () => {
        normalizeValue();
        triggerUpdate(true);
      });

      input.addEventListener("blur", () => {
        // Ensure value present on blur
        if (input.value === "" || isNaN(parseFloat(input.value))) {
          const min = input.getAttribute("min");
          input.value = min !== null && min !== "" ? min : "1";
        }
        normalizeValue();
        triggerUpdate(true);
      });
    });
  }

  /* /Cart: auto-update on manual input */

  /* Mobile mobile toggle */

  document.querySelectorAll("#main-footer .widget-title").forEach((title) => {
    title.addEventListener("click", function () {
      if (window.innerWidth < 992) {
        const menuCol = this.closest(".menu-col");

        if (menuCol) {
          menuCol.classList.toggle("show");
        }
      }
    });
  });

  /* Mobile menu dropdown toggle */

  const menuLinks = document.querySelectorAll(
    ".site-header #primary-menu-list > li.menu-item-has-children > a"
  );

  menuLinks.forEach(function (link) {
    link.addEventListener("click", function (e) {
      if (window.innerWidth < 992) {
        e.preventDefault();

        const menuItem = this.closest(".menu-item");
        const dropdown = menuItem.querySelector(".dropdown-menu");

        if (!dropdown) return;

        const isOpen = dropdown.style.maxHeight;

        if (isOpen) {
          // Close
          dropdown.style.maxHeight = null;
          dropdown.style.overflow = "hidden";
          menuItem.classList.remove("opened");
        } else {
          // Open
          dropdown.style.maxHeight = dropdown.scrollHeight + "px";
          dropdown.style.overflow = "hidden";
          menuItem.classList.add("opened");
        }
      }
    });
  });

  /* /Mobile menu dropdown toggle */

  /* Sidebar mobile widget toggle */

  const sidebarWidgetTitles = document.querySelectorAll(
    ".sidebar .widget .widget-title"
  );

  sidebarWidgetTitles.forEach(function (title) {
    title.addEventListener("click", function () {
      if (window.innerWidth < 992) {
        const widget = title.closest(".widget");

        if (widget) {
          widget.classList.toggle("mobile-show");
        }
      }
    });
  });

  /* Filters toggle */

  const filterNames = document.querySelectorAll(
    ".sidebar .widget .filter .filter-name"
  );

  if (filterNames.length > 0) {
    filterNames.forEach(function (el) {
      el.addEventListener("click", function () {
        const filter = el.closest(".filter");

        if (filter) {
          filter.classList.toggle("opened");
        }
      });
    });
  }

  /* Product page read more button */

  const readFullButtons = document.querySelectorAll(".read-full");

  if (readFullButtons.length > 0) {
    readFullButtons.forEach(function (readMoreBtn) {
      readMoreBtn.addEventListener("click", function (e) {
        const detailsContainer = e.target.closest(".details");
        if (detailsContainer) {
          const shortDesc = detailsContainer.querySelector(".short-desc");
          const detailedDesc = detailsContainer.querySelector(".detailed-desc");
          const button = e.target;

          if (detailedDesc && shortDesc) {
            if (
              detailedDesc.style.display === "none" ||
              detailedDesc.style.display === ""
            ) {
              // Show detailed description with smooth animation
              detailedDesc.style.display = "block";
              detailedDesc.style.transition = "opacity 0.4s ease-in-out";

              // Trigger reflow to ensure transition works
              detailedDesc.offsetHeight;

              detailedDesc.style.opacity = "1";

              // Hide the button immediately
              button.style.display = "none";
            }
          }
        }
      });
    });
  }

  /* Sidebar products swiper */

  document
    .querySelectorAll(".container.has-aside .sidebar-products-swiper")
    .forEach((holder) => {
      const swiperContainer = holder.querySelector(".swiper");

      if (swiperContainer) {
        new Swiper(swiperContainer, {
          slidesPerView: 1,
          spaceBetween: 20,
          autoHeight: true,
          loop: false,
          pagination: {
            el: holder.querySelector(".swiper-pagination"),
            clickable: true,
          },
        });
      }
    });

  /* Related posts items swiper */

  document
    .querySelectorAll(".related-posts .posts-swiper")
    .forEach((holder) => {
      const swiperContainer = holder.querySelector(".swiper");

      if (swiperContainer) {
        new Swiper(swiperContainer, {
          slidesPerView: 3,
          spaceBetween: 20,
          loop: false,
          navigation: {
            nextEl: holder.querySelector(".swiper-button-next"),
            prevEl: holder.querySelector(".swiper-button-prev"),
          },

          pagination: false,
          breakpoints: {
            0: {
              slidesPerView: 1.2,
            },

            640: {
              slidesPerView: 2,
              spaceBetween: 30,
            },

            1200: {
              slidesPerView: 3,
              spaceBetween: 30,
            },

            1400: {
              slidesPerView: 3,
              spaceBetween: 42,
            },
          },
        });
      }
    });

  /* Reviews swiper */

  document.querySelectorAll(".reviews-swiper").forEach((holder) => {
    const swiperContainer = holder.querySelector(".swiper");
    const slides = swiperContainer
      ? swiperContainer.querySelectorAll(".swiper-slide")
      : [];

    if (swiperContainer && slides.length > 0) {
      new Swiper(swiperContainer, {
        slidesPerView: "auto",
        spaceBetween: 20,
        loop: slides.length > 3, // Only loop if we have more than 3 slides
        pagination: {
          el: holder.querySelector(".swiper-pagination"),
          clickable: true,
        },

        breakpoints: {
          0: {
            slidesPerView: slides.length >= 2 ? 1.2 : 1,
            spaceBetween: 20,
          },

          640: {
            slidesPerView: slides.length >= 3 ? 2 : slides.length,
            spaceBetween: 30,
          },

          1400: {
            slidesPerView: slides.length >= 4 ? 3 : slides.length,
            spaceBetween: 20,
          },
        },
      });
    }
  });

  /* Sidebar file input */

  const fileInput = document.querySelector('.file-input input[type="file"]');
  const fileLabel = document.querySelector(".file-input span");

  if (fileInput && fileLabel) {
    fileLabel.addEventListener("click", function () {
      fileInput.click();
    });

    fileInput.addEventListener("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        fileLabel.textContent = file.name;
      } else {
        fileLabel.textContent = "Atlasīt pielikumu ierīcē";
      }
    });
  }

  /* Gravity Forms file upload enhancement */

  // Handle single file upload fields
  const gformFileInputs = document.querySelectorAll(
    '.gform_wrapper .gfield input[type="file"]'
  );

  gformFileInputs.forEach(function (fileInput) {
    const container = fileInput.closest(".ginput_container_fileupload");
    if (container) {
      // Make the entire container clickable
      container.style.cursor = "pointer";

      container.addEventListener("click", function (e) {
        // Trigger for any click within the container
        fileInput.click();
      });
    }
  });

  // Handle multi-file upload areas
  const gformDropAreas = document.querySelectorAll(
    ".gform_fileupload_multifile .gform_drop_area"
  );

  gformDropAreas.forEach(function (dropArea) {
    const selectButton = dropArea.querySelector(".gform_button_select_files");
    if (selectButton) {
      // Make the entire drop area clickable
      dropArea.style.cursor = "pointer";

      dropArea.addEventListener("click", function (e) {
        // Trigger for any click within the drop area
        selectButton.click();
      });
    }
  });

  // Style GF file field in order form id=2 like sidebar .file-input
  const styleGfOrderForm2File = () => {
    const gf2 = document.getElementById("gform_wrapper_2");
    if (!gf2) return;
    const containers = gf2.querySelectorAll(
      ".ginput_container_fileupload:not(.file-input)"
    );
    containers.forEach((container) => {
      container.classList.add("file-input");
      // Add visible label if missing
      const hasSpan = container.querySelector("span");
      if (!hasSpan) {
        const span = document.createElement("span");
        span.textContent = "Atlasīt pielikumu ierīcē";
        container.appendChild(span);
      }
    });

    // Replace default GF file size text with our label and ensure white color
    const fileFields = gf2.querySelectorAll(".gfield--type-fileupload");
    fileFields.forEach((field) => {
      const rules =
        field.querySelector(".gform_fileupload_rules") ||
        field.querySelector(".gfield_description");
      if (rules) {
        rules.textContent = "Atlasīt pielikumu ierīcē";
        rules.style.color = "#fff";
        rules.style.textDecoration = "underline";
        rules.style.cursor = "pointer";
      }
    });
  };

  // Run on load
  styleGfOrderForm2File();
  // And after GF renders via AJAX
  if (typeof $ !== "undefined") {
    $(document).on("gform_post_render", function (_e, formId) {
      if (String(formId) === "2") styleGfOrderForm2File();
    });
  }

  /* Sidebar widget show / hide dropdown */

  const sidebarDropdownToggles = document.querySelectorAll(
    ".sidebar .category-item.dropdown > a, .sidebar .category-item.dropdown > button"
  );

  if (sidebarDropdownToggles.length > 0) {
    sidebarDropdownToggles.forEach((title) => {
      title.addEventListener("click", function (e) {
        this.parentElement.classList.toggle("show");
        e.preventDefault();
      });
    });
  }

  /* Video Player Enhancements */

  // Initialize video holders with custom controls
  const videoHolders = document.querySelectorAll(".video-holder");

  if (videoHolders.length > 0) {
    videoHolders.forEach((holder) => {
      const video = holder.querySelector(".bg-video");
      const playBtn = holder.querySelector(".play-btn");

      if (video && playBtn) {
        const pauseBtn = holder.querySelector(".pause-btn");

        // Track if video has been played for the first time
        let hasBeenPlayed = false;

        // Play video when play button is clicked
        playBtn.addEventListener("click", function () {
          video.muted = false; // Unmute when user clicks play
          video.play();
          hasBeenPlayed = true;
          holder.classList.add("playing");
          holder.classList.add("has-been-played");
        });

        // Pause video when pause button is clicked
        if (pauseBtn) {
          pauseBtn.addEventListener("click", function () {
            video.pause();
            holder.classList.remove("playing");
          });
        }

        // Hide details when video starts playing
        video.addEventListener("play", function () {
          hasBeenPlayed = true;
          holder.classList.add("playing");
          holder.classList.add("has-been-played");
        });

        // Show details when video is paused (only if not played before)
        video.addEventListener("pause", function () {
          if (!hasBeenPlayed) {
            holder.classList.remove("playing");
          }
        });

        // Show details when video ends (only if not played before)
        video.addEventListener("ended", function () {
          if (!hasBeenPlayed) {
            holder.classList.remove("playing");
          }
        });

        // Hide details initially if video is already playing
        if (!video.paused) {
          hasBeenPlayed = true;
          holder.classList.add("playing");
          holder.classList.add("has-been-played");
        }

        // Add error handling
        video.addEventListener("error", function (e) {
          console.error("Video error:", e);
        });

        // Add loaded metadata event
        video.addEventListener("loadedmetadata", function () {
          console.log("Video loaded:", this.src);
        });

        // Handle video seeking with loading spinner
        const loadingSpinner = holder.querySelector(".video-loading-spinner");

        video.addEventListener("seeking", function () {
          if (loadingSpinner) {
            loadingSpinner.style.display = "flex";
          }
        });

        video.addEventListener("seeked", function () {
          if (loadingSpinner) {
            loadingSpinner.style.display = "none";
          }
        });

        video.addEventListener("waiting", function () {
          if (loadingSpinner) {
            loadingSpinner.style.display = "flex";
          }
        });

        video.addEventListener("canplay", function () {
          if (loadingSpinner) {
            loadingSpinner.style.display = "none";
          }
        });
      }
    });
  }

  /* Sidebar product categories toggle */

  const sidebarCategoriesToggle = document.querySelector(
    ".sidebar .product-categories-toggle"
  );

  if (sidebarCategoriesToggle) {
    sidebarCategoriesToggle.addEventListener("click", function () {
      const sidebar = sidebarCategoriesToggle.closest(".sidebar");
      if (!sidebar) return;

      const categories = sidebar.querySelector(".product-categories");

      if (categories) {
        categories.classList.toggle("show");
      }

      sidebarCategoriesToggle.classList.toggle("opened");
    });
  }

  /* Fancybox Gallery Initialization */

  // Initialize Fancybox for gallery images
  if (typeof $ !== "undefined" && $.fn.fancybox) {
    $('[data-fancybox="gallery"]').fancybox({
      loop: true,
      buttons: ["zoom", "slideShow", "thumbs", "close"],
      animationEffect: "zoom-in-out",
      transitionEffect: "slide",
      thumbs: {
        autoStart: false,
      },
      slideShow: {
        autoStart: false,
        speed: 3000,
      },
      protect: true,
      touch: {
        vertical: true,
        momentum: true,
      },
      mobile: {
        preventCaptionOverlap: false,
        toolbar: false,
        buttons: ["close"],
      },
    });
  }

  /* Copy to Clipboard Function */

  // Global function for copying text to clipboard
  window.copyToClipboard = function (text) {
    if (navigator.clipboard && window.isSecureContext) {
      // Use modern clipboard API
      navigator.clipboard
        .writeText(text)
        .then(function () {
          showCopyNotification();
        })
        .catch(function (err) {
          console.error("Could not copy text: ", err);
          fallbackCopyTextToClipboard(text);
        });
    } else {
      // Fallback for older browsers
      fallbackCopyTextToClipboard(text);
    }
  };

  function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
      const successful = document.execCommand("copy");
      if (successful) {
        showCopyNotification();
      }
    } catch (err) {
      console.error("Fallback: Oops, unable to copy", err);
    }

    document.body.removeChild(textArea);
  }

  function showCopyNotification() {
    // Create notification element
    const notification = document.createElement("div");
    notification.textContent = "Saiti nokopēta!";
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      background: #28a745;
      color: white;
      padding: 12px 20px;
      border-radius: 4px;
      z-index: 9999;
      font-size: 14px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    `;

    document.body.appendChild(notification);

    // Remove notification after 3 seconds
    setTimeout(function () {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 3000);
  }

  /* Quantity controls functionality */
  const attachQtyHandlers = () => {
    if (window.__vpQtyHandlersBound) return;
    window.__vpQtyHandlersBound = true;

    // Legacy markup: .quantity-controls with .quantity-btn (data-action)
    document.addEventListener("click", function (e) {
      const btn = e.target.closest(".quantity-btn");
      if (!btn) return;
      e.preventDefault();
      const controlsContainer = btn.closest(".quantity-controls");
      const input = controlsContainer?.querySelector(".quantity-input");
      if (!input) return;
      const currentValue = parseInt(input.value) || 1;
      const action = btn.getAttribute("data-action");
      if (action === "increase") {
        if (currentValue < parseInt(input.max) || !input.max) input.value = currentValue + 1;
      } else if (action === "decrease") {
        if (currentValue > parseInt(input.min) || !input.min) input.value = Math.max(1, currentValue - 1);
      }
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });

    // New markup: .quantity with .minus/.plus and sibling input
    document.addEventListener("click", function (e) {
      const minus = e.target.closest(".quantity .minus");
      const plus = e.target.closest(".quantity .plus");
      if (!minus && !plus) return;
      e.preventDefault();
      const container = (minus || plus).closest(".quantity");
      const input = container?.querySelector("input[type='number']");
      if (!input) return;
      const currentValue = parseInt(input.value) || 1;
      if (plus) {
        if (currentValue < parseInt(input.max) || !input.max) input.value = currentValue + 1;
      } else if (minus) {
        if (currentValue > parseInt(input.min) || !input.min) input.value = Math.max(1, currentValue - 1);
      }
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
  };

  attachQtyHandlers();
});
