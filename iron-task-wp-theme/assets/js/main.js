/**
 * Iron Task Theme - Main JavaScript
 * 
 * @package Iron_Task
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Iron Task Namespace
    const IronTask = {
        config: {
            navbarHeight: 72,
            scrollThreshold: 100,
            loaderDelay: 1500
        },

        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.hideLoader();
            this.initTheme();
            this.initReveal();
            this.initNavbar();
            this.initMobileMenu();
            this.initRipple();
        },

        cacheElements: function() {
            this.$body = $('body');
            this.$navbar = $('#navbar');
            this.$loader = $('#loader');
            this.$menuToggle = $('#menu-toggle');
            this.$navbarNav = $('#navbar-nav');
            this.$themeToggle = $('#theme-toggle');
        },

        bindEvents: function() {
            const self = this;

            // Scroll events
            $(window).on('scroll', function() {
                self.handleScroll();
            });

            // Menu toggle
            if (this.$menuToggle.length) {
                this.$menuToggle.on('click', function() {
                    self.toggleMobileMenu();
                });
            }

            // Theme toggle
            if (this.$themeToggle.length) {
                this.$themeToggle.on('click', function() {
                    self.toggleTheme();
                });
            }

            // Close mobile menu on link click
            this.$navbarNav.on('click', 'a', function() {
                self.closeMobileMenu();
            });

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.hash);
                if (target.length) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - self.config.navbarHeight
                    }, 800);
                }
            });

            // Add to cart AJAX
            $(document).on('click', '.add_to_cart_button', function(e) {
                self.handleAddToCart(e, $(this));
            });
        },

        handleScroll: function() {
            const scrollTop = $(window).scrollTop();

            // Navbar hide/show on scroll
            if (scrollTop > this.config.scrollThreshold) {
                this.$navbar.addClass('navbar--hidden');
            } else {
                this.$navbar.removeClass('navbar--hidden');
            }

            // Navbar background on scroll
            if (scrollTop > 50) {
                this.$navbar.css('background-color', 'rgba(10, 10, 12, 0.98)');
            } else {
                this.$navbar.css('background-color', 'rgba(10, 10, 12, 0.95)');
            }
        },

        hideLoader: function() {
            const self = this;
            setTimeout(function() {
                self.$loader.addClass('loader--hidden');
                setTimeout(function() {
                    self.$loader.remove();
                }, 500);
            }, this.config.loaderDelay);
        },

        initTheme: function() {
            const savedTheme = localStorage.getItem('iron-task-theme') || 'dark';
            this.setTheme(savedTheme);
        },

        toggleTheme: function() {
            const currentTheme = this.$body.attr('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            this.setTheme(newTheme);
            localStorage.setItem('iron-task-theme', newTheme);
        },

        setTheme: function(theme) {
            this.$body.attr('data-theme', theme);
            document.documentElement.setAttribute('data-theme', theme);
            
            const $lightIcon = $('.theme-toggle__icon--light');
            const $darkIcon = $('.theme-toggle__icon--dark');
            
            if (theme === 'dark') {
                $lightIcon.show();
                $darkIcon.hide();
            } else {
                $lightIcon.hide();
                $darkIcon.show();
            }
        },

        initReveal: function() {
            const revealElements = document.querySelectorAll('.reveal');
            
            const revealOnScroll = () => {
                const windowHeight = window.innerHeight;
                const elementVisible = 150;

                revealElements.forEach((element) => {
                    const elementTop = element.getBoundingClientRect().top;
                    if (elementTop < windowHeight - elementVisible) {
                        element.classList.add('revealed');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll(); // Check on load
        },

        initNavbar: function() {
            let lastScroll = 0;
            const navbar = this.$navbar[0];

            $(window).on('scroll', () => {
                const currentScroll = $(window).scrollTop();
                
                if (currentScroll <= 0) {
                    navbar.classList.remove('navbar--hidden');
                    return;
                }

                if (currentScroll > lastScroll && currentScroll > this.config.navbarHeight) {
                    navbar.classList.add('navbar--hidden');
                } else {
                    navbar.classList.remove('navbar--hidden');
                }
                
                lastScroll = currentScroll;
            });
        },

        initMobileMenu: function() {
            const menuToggle = this.$menuToggle[0];
            const navbarNav = this.$navbarNav[0];
            const openIcon = document.querySelector('.menu-toggle__icon--open');
            const closeIcon = document.querySelector('.menu-toggle__icon--close');

            if (!menuToggle || !navbarNav) return;

            menuToggle.addEventListener('click', () => {
                const isOpen = navbarNav.classList.contains('navbar__nav--open');
                
                if (isOpen) {
                    navbarNav.classList.remove('navbar__nav--open');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    if (openIcon) openIcon.style.display = 'block';
                    if (closeIcon) closeIcon.style.display = 'none';
                } else {
                    navbarNav.classList.add('navbar__nav--open');
                    menuToggle.setAttribute('aria-expanded', 'true');
                    if (openIcon) openIcon.style.display = 'none';
                    if (closeIcon) closeIcon.style.display = 'block';
                }
            });
        },

        toggleMobileMenu: function() {
            const isOpen = this.$navbarNav.hasClass('navbar__nav--open');
            
            if (isOpen) {
                this.closeMobileMenu();
            } else {
                this.openMobileMenu();
            }
        },

        openMobileMenu: function() {
            this.$navbarNav.addClass('navbar__nav--open');
            this.$menuToggle.attr('aria-expanded', 'true');
            this.$body.css('overflow', 'hidden');
        },

        closeMobileMenu: function() {
            this.$navbarNav.removeClass('navbar__nav--open');
            this.$menuToggle.attr('aria-expanded', 'false');
            this.$body.css('overflow', '');
        },

        initRipple: function() {
            $(document).on('click', '.btn', function(e) {
                const $btn = $(this);
                const ripple = $('<span class="ripple"></span>');
                const offset = $btn.offset();
                const x = e.pageX - offset.left;
                const y = e.pageY - offset.top;

                ripple.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                $btn.append(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        },

        handleAddToCart: function(e, $button) {
            if (typeof ironTaskData === 'undefined') return;

            e.preventDefault();
            
            const productId = $button.data('product_id') || $button.closest('.product').data('product_id');
            
            if (!productId) return;

            $.ajax({
                url: ironTaskData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'iron_task_add_to_cart',
                    nonce: ironTaskData.nonce,
                    product_id: productId,
                    quantity: 1
                },
                beforeSend: function() {
                    $button.prop('disabled', true).text(ironTaskData.i18n.loading);
                },
                success: function(response) {
                    if (response.success) {
                        IronTask.showToast(response.data.message, 'success');
                        $('#cart-count').text(response.data.cartCount);
                    } else {
                        IronTask.showToast(response.data.message || ironTaskData.i18n.error, 'error');
                    }
                },
                error: function() {
                    IronTask.showToast(ironTaskData.i18n.error, 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).text($button.data('text') || 'Adicionar ao Carrinho');
                }
            });
        },

        showToast: function(message, type = 'success') {
            const $toast = $('<div class="toast toast--' + type + '">' + message + '</div>');
            $('#toast-container').append($toast);

            setTimeout(() => {
                $toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    };

    // Initialize on DOM ready
    $(document).ready(function() {
        IronTask.init();
    });

})(jQuery);
