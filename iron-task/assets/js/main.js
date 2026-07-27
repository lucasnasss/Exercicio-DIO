/**
 * Iron Task - Main JavaScript
 *
 * @package Iron_Task
 * @since 1.0.0
 */

(function() {
	'use strict';

	// =============================================
	// CONFIGURAÇÕES GERAIS
	// =============================================
	const config = {
		loaderDuration: 2000,
		scrollThreshold: 300,
		navbarHeight: 72,
		breakpoints: {
			mobile: 768,
			tablet: 1024,
		},
	};

	// =============================================
	// ELEMENTOS DOM
	// =============================================
	const elements = {
		loader: null,
		navbar: null,
		btnMenu: null,
		btnMenuClose: null,
		mobileMenu: null,
		mobileOverlay: null,
		btnTheme: null,
		btnCart: null,
		btnSearch: null,
		cartCount: null,
		megaMenu: null,
		toastContainer: null,
		backToTop: null,
	};

	// =============================================
	// ESTADO DA APLICAÇÃO
	// =============================================
	const state = {
		isMenuOpen: false,
		isLoading: true,
		currentTheme: 'dark',
		cartCount: 0,
	};

	// =============================================
	// INICIALIZAÇÃO
	// =============================================
	function init() {
		cacheElements();
		initLoader();
		initThemeToggle();
		initMobileMenu();
		initNavbarScroll();
		initCart();
		initSearch();
		initMegaMenu();
		initSmoothScroll();
		initAnimations();
		
		// Atualiza estado inicial
		state.isLoading = false;
	}

	// =============================================
	// CACHE DE ELEMENTOS
	// =============================================
	function cacheElements() {
		elements.loader = document.getElementById('loader');
		elements.navbar = document.getElementById('navbar');
		elements.btnMenu = document.getElementById('btn-menu');
		elements.btnMenuClose = document.getElementById('btn-menu-close');
		elements.mobileMenu = document.getElementById('mobile-menu');
		elements.mobileOverlay = document.getElementById('mobile-overlay');
		elements.btnTheme = document.getElementById('btn-theme');
		elements.btnCart = document.getElementById('btn-cart');
		elements.btnSearch = document.getElementById('btn-search');
		elements.cartCount = document.getElementById('cart-count');
		elements.megaMenu = document.getElementById('mega-menu');
		elements.toastContainer = document.getElementById('toast-container');
		elements.backToTop = document.getElementById('backToTop');
	}

	// =============================================
	// LOADER
	// =============================================
	function initLoader() {
		if (!elements.loader) {
			console.warn('Loader element not found');
			state.isLoading = false;
			return;
		}

		// Força o loader a ser visível inicialmente
		elements.loader.style.opacity = '1';
		elements.loader.style.visibility = 'visible';

		setTimeout(() => {
			elements.loader.classList.add('loader--hidden');
			
			// Remove do DOM após animação
			setTimeout(() => {
				elements.loader.style.display = 'none';
				elements.loader.setAttribute('aria-hidden', 'true');
				state.isLoading = false;
			}, 600);
		}, config.loaderDuration);
	}

	// =============================================
	// THEME TOGGLE
	// =============================================
	function initThemeToggle() {
		if (!elements.btnTheme) return;

		// Carrega tema salvo ou usa preferência do sistema
		const savedTheme = localStorage.getItem('iron-task-theme');
		const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
		
		state.currentTheme = savedTheme || (prefersDark ? 'dark' : 'light');
		document.documentElement.setAttribute('data-theme', state.currentTheme);

		elements.btnTheme.addEventListener('click', toggleTheme);
	}

	function toggleTheme() {
		state.currentTheme = state.currentTheme === 'dark' ? 'light' : 'dark';
		document.documentElement.setAttribute('data-theme', state.currentTheme);
		localStorage.setItem('iron-task-theme', state.currentTheme);
		
		// Toast de feedback
		showToast(
			state.currentTheme === 'dark' 
				? 'Modo escuro ativado' 
				: 'Modo claro ativado',
			'success'
		);
	}

	// =============================================
	// MOBILE MENU
	// =============================================
	function initMobileMenu() {
		if (!elements.btnMenu || !elements.mobileMenu) return;

		elements.btnMenu.addEventListener('click', toggleMobileMenu);
		
		if (elements.btnMenuClose) {
			elements.btnMenuClose.addEventListener('click', closeMobileMenu);
		}
		
		if (elements.mobileOverlay) {
			elements.mobileOverlay.addEventListener('click', closeMobileMenu);
		}

		// Fecha menu ao pressionar ESC
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && state.isMenuOpen) {
				closeMobileMenu();
			}
		});

		// Previne scroll quando menu está aberto
		elements.mobileMenu.addEventListener('touchmove', (e) => {
			e.stopPropagation();
		}, { passive: true });
	}

	function toggleMobileMenu() {
		state.isMenuOpen = !state.isMenuOpen;
		updateMobileMenuState();
	}

	function closeMobileMenu() {
		state.isMenuOpen = false;
		updateMobileMenuState();
	}

	function updateMobileMenuState() {
		const isOpen = state.isMenuOpen;
		
		elements.btnMenu.classList.toggle('navbar__hamburger--open', isOpen);
		elements.btnMenu.setAttribute('aria-expanded', isOpen);
		elements.mobileMenu.classList.toggle('mobile-menu--open', isOpen);
		elements.mobileMenu.setAttribute('aria-hidden', !isOpen);
		
		if (elements.mobileOverlay) {
			elements.mobileOverlay.classList.toggle('mobile-overlay--visible', isOpen);
			elements.mobileOverlay.setAttribute('aria-hidden', !isOpen);
		}

		// Previne scroll do body quando menu está aberto
		document.body.style.overflow = isOpen ? 'hidden' : '';
	}

	// =============================================
	// NAVBAR SCROLL EFFECT
	// =============================================
	function initNavbarScroll() {
		if (!elements.navbar) return;

		let lastScrollY = window.scrollY;

		window.addEventListener('scroll', () => {
			const currentScrollY = window.scrollY;

			// Adiciona classe quando scrolled
			if (currentScrollY > config.scrollThreshold) {
				elements.navbar.classList.add('navbar--scrolled');
			} else {
				elements.navbar.classList.remove('navbar--scrolled');
			}

			lastScrollY = currentScrollY;
		}, { passive: true });
	}

	// =============================================
	// CART FUNCTIONALITY
	// =============================================
	function initCart() {
		if (!elements.btnCart) return;

		// Atualiza contador do carrinho via AJAX (WooCommerce fragments)
		// O WooCommerce já atualiza automaticamente via wc_add_to_cart_fragments
		
		elements.btnCart.addEventListener('click', () => {
			if (window.ironTaskConfig && window.ironTaskConfig.isWooCommerce) {
				window.location.href = '/cart/';
			}
		});

		// Animação de bump quando produto é adicionado
		document.addEventListener('added_to_cart', () => {
			if (elements.cartCount) {
				elements.cartCount.classList.add('navbar__cart-count--bump');
				
				setTimeout(() => {
					elements.cartCount.classList.remove('navbar__cart-count--bump');
				}, 300);
			}
			
			showToast('Produto adicionado ao carrinho!', 'success');
		});
	}

	// =============================================
	// SEARCH FUNCTIONALITY
	// =============================================
	function initSearch() {
		if (!elements.btnSearch) return;

		elements.btnSearch.addEventListener('click', () => {
			// Pode implementar search modal aqui
			const searchQuery = prompt('O que você procura?');
			
			if (searchQuery && searchQuery.trim()) {
				window.location.href = '/?s=' + encodeURIComponent(searchQuery.trim());
			}
		});
	}

	// =============================================
	// MEGA MENU
	// =============================================
	function initMegaMenu() {
		if (!elements.megaMenu) return;

		// Fecha mega menu ao clicar fora
		document.addEventListener('click', (e) => {
			if (!e.target.closest('.navbar__item--mega')) {
				elements.megaMenu.classList.remove('mega-menu--visible');
			}
		});

		// Suporte a teclado para acessibilidade
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape') {
				elements.megaMenu.classList.remove('mega-menu--visible');
			}
		});
	}

	// =============================================
	// SMOOTH SCROLL
	// =============================================
	function initSmoothScroll() {
		// Smooth scroll para links internos
		document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
			anchor.addEventListener('click', function(e) {
				const targetId = this.getAttribute('href');
				
				if (targetId === '#') return;
				
				const targetElement = document.querySelector(targetId);
				
				if (targetElement) {
					e.preventDefault();
					
					const navbarHeight = elements.navbar ? elements.navbar.offsetHeight : 0;
					const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - navbarHeight;
					
					window.scrollTo({
						top: targetPosition,
						behavior: 'smooth',
					});
				}
			});
		});
	}

	// =============================================
	// ANIMAÇÕES AO SCROLL
	// =============================================
	function initAnimations() {
		// Intersection Observer para animações ao scroll
		const observerOptions = {
			root: null,
			rootMargin: '0px',
			threshold: 0.1,
		};

		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('animate-in');
					observer.unobserve(entry.target);
				}
			});
		}, observerOptions);

		// Observa elementos com classe .animate-on-scroll
		document.querySelectorAll('.animate-on-scroll').forEach((el) => {
			observer.observe(el);
		});
	}

	// =============================================
	// TOAST NOTIFICATIONS
	// =============================================
	function showToast(message, type = 'success') {
		if (!elements.toastContainer) return;

		const toast = document.createElement('div');
		toast.className = `toast toast--${type}`;
		toast.textContent = message;
		toast.setAttribute('role', 'alert');

		elements.toastContainer.appendChild(toast);

		// Remove toast após animação
		setTimeout(() => {
			toast.remove();
		}, 3000);
	}

	// =============================================
	// UTILITÁRIOS
	// =============================================
	function debounce(func, wait) {
		let timeout;
		return function executedFunction(...args) {
			const later = () => {
				clearTimeout(timeout);
				func(...args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}

	function throttle(func, limit) {
		let inThrottle;
		return function(...args) {
			if (!inThrottle) {
				func.apply(this, args);
				inThrottle = true;
				setTimeout(() => (inThrottle = false), limit);
			}
		};
	}

	// =============================================
	// EXPORTS (para uso global se necessário)
	// =============================================
	window.IronTask = {
		init,
		showToast,
		toggleTheme,
		closeMobileMenu,
		config,
		state,
	};

	// =============================================
	// INICIALIZA QUANDO DOM ESTIVER PRONTO
	// =============================================
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
