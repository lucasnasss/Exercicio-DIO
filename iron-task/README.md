# Iron Task - Tema WordPress para WooCommerce

Tema profissional para WordPress totalmente compatível com WooCommerce, desenvolvido com base em um site estático HTML/CSS/JavaScript.

## 📋 Visão Geral

**Iron Task** é um tema moderno e responsivo focado em e-commerce de moda esportiva e streetwear. O tema preserva o layout, identidade visual, animações e experiência do usuário do projeto original, adaptando-os para o ecossistema WordPress.

### Características Principais

- ✅ Compatível com WordPress 6.4+
- ✅ Totalmente integrado com WooCommerce
- ✅ PHP 8+ compatível
- ✅ Design responsivo (mobile-first)
- ✅ Dark/Light mode toggle
- ✅ Otimizado para Core Web Vitals
- ✅ SEO-friendly com structured data
- ✅ Acessibilidade (WCAG 2.1)
- ✅ WordPress Coding Standards

---

## 📁 Estrutura do Tema

```
iron-task/
├── style.css                 # Folha de estilo principal + metadados do tema
├── functions.php             # Funções principais e inicialização
├── index.php                 # Template fallback principal
├── front-page.php            # Template da página inicial
├── home.php                  # Template da página de posts
├── single.php                # Template de post individual
├── page.php                  # Template de página estática
├── archive.php               # Template de arquivos (categorias, tags, etc.)
├── search.php                # Template de resultados de busca
├── 404.php                   # Template de erro 404
├── header.php                # Cabeçalho do site
├── footer.php                # Rodapé do site
├── sidebar.php               # Sidebar padrão
├── comments.php              # Template de comentários
├── screenshot.png            # Captura do tema (1200x900px)
│
├── assets/
│   ├── css/
│   │   └── editor-style.css  # Estilos para o editor Gutenberg
│   ├── js/
│   │   └── main.js           # JavaScript principal do tema
│   └── images/
│       └── (imagens do tema)
│
├── inc/
│   ├── class-iron-task-setup.php         # Configurações do tema
│   ├── class-iron-task-scripts.php       # Gerenciamento de scripts/styles
│   ├── class-iron-task-widgets.php       # Widgets customizados
│   ├── class-iron-task-template-tags.php # Template tags helper
│   └── class-iron-task-woocommerce.php   # Integração WooCommerce
│
├── template-parts/
│   ├── header/
│   │   ├── navbar.php        # Componente de navegação
│   │   └── mobile-menu.php   # Menu mobile
│   ├── footer/
│   │   └── site.php          # Componente do rodapé
│   ├── product/
│   │   └── card.php          # Card de produto
│   ├── sections/
│   │   ├── hero.php          # Seção hero
│   │   ├── features.php      # Seção de features
│   │   ├── testimonials.php  # Depoimentos
│   │   └── cta.php           # Call-to-action
│   └── global/
│       ├── loader.php        # Loader animation
│       └── toast.php         # Notificações toast
│
├── woocommerce/
│   ├── cart/
│   │   └── cart.php          # Template customizado do carrinho
│   ├── single-product/
│   │   └── content-single.php # Template de produto único
│   ├── archive/
│   │   └── product.php       # Template de listagem de produtos
│   └── global/
│       └── wrapper.php       # Wrappers do WooCommerce
│
└── languages/
    └── iron-task.pot         # Arquivo de tradução
```

---

## 📄 Descrição dos Arquivos Principais

### `style.css`
Contém todos os estilos do tema, incluindo:
- Design system completo (variáveis CSS, cores, tipografia)
- Layout responsivo
- Componentes UI (navbar, cards, botões, etc.)
- Estilos específicos do WooCommerce
- Animações e transições
- Modos dark/light theme

### `functions.php`
Arquivo principal de configuração que:
- Carrega classes de funcionalidades
- Registra menus, sidebars e image sizes
- Adiciona suporte a recursos do WordPress/WooCommerce
- Implementa hooks e filtros customizados
- Otimiza performance (remove emojis, versões, etc.)

### `header.php`
Estrutura do cabeçalho incluindo:
- Meta tags e head do WordPress
- Loader animation
- Navbar com menu principal
- Botões de ação (busca, tema, carrinho)
- Mega menu para categorias
- Menu mobile overlay

### `footer.php`
Estrutura do rodapé com:
- Links institucionais
- Newsletter signup
- Redes sociais
- Badges informativos
- Toast container
- Scripts do WordPress

### `front-page.php`
Template da página inicial com seções:
- Hero section
- Produtos em destaque
- Categorias
- Features/benefícios
- Testimonials
- Call-to-action final

### `single.php`
Template para posts individuais:
- Header com título e meta informações
- Conteúdo do post
- Tags e compartilhamento
- Autor box
- Posts relacionados
- Comentários

### `archive.php`
Template para arquivos:
- Categorias
- Tags
- Datas
- Autores
- Custom post types

### `search.php`
Resultados de busca:
- Query display
- Contador de resultados
- Grid de produtos/posts
- Paginação
- Fallback para sem resultados

### `404.php`
Página de erro customizada:
- Mensagem amigável
- Links de navegação
- Formulário de busca

### `comments.php`
Sistema de comentários:
- Lista de comentários
- Paginação
- Formulário de resposta

---

## 🛍️ Integração WooCommerce

O tema inclui integração completa com WooCommerce:

### Páginas Suportadas
- ✅ Loja (shop)
- ✅ Página de produto único
- ✅ Carrinho
- ✅ Checkout
- ✅ Minha Conta
- ✅ Busca de produtos

### Recursos Implementados
- Mini cart no header
- Contador de itens no carrinho (atualização AJAX)
- Grid de produtos responsivo
- Badges de produto (Oferta, Novo, Destaque)
- Produtos relacionados
- Upsells products
- Breadcrumbs nativos
- Structured data para produtos (SEO)

### Hooks Utilizados
```php
// Antes do conteúdo WooCommerce
add_action('woocommerce_before_main_content', 'wrapper_before');

// Depois do conteúdo WooCommerce
add_action('woocommerce_after_main_content', 'wrapper_after');

// Fragmentos do carrinho (AJAX)
add_filter('woocommerce_add_to_cart_fragments', 'cart_count_fragments');

// Colunas da loja
add_filter('loop_shop_columns', 'shop_columns');
```

---

## 🎨 Componentes UI

### Navbar
- Logo (SVG ou custom logo do WordPress)
- Menu principal com dropdown
- Mega menu para categorias
- Toggle de tema (dark/light)
- Ícone de busca
- Mini cart com contador
- Menu hamburger (mobile)

### Mobile Menu
- Overlay com backdrop blur
- Navegação swipe-friendly
- Sub-menus expansíveis
- Links sociais no footer
- Fecha com ESC ou clique fora

### Product Card
- Imagem com aspect ratio 3:4
- Badge dinâmico (Oferta/Novo/Destaque)
- Nome e preço
- Hover effects
- Quick view (opcional)

### Toast Notifications
- Feedback de ações
- Auto-dismiss após 3s
- Tipos: success, error, info
- Posição fixa bottom-right

---

## ⚡ Performance & SEO

### Otimizações Implementadas
- Lazy loading nativo em imagens
- Preconnect para Google Fonts
- Remove jQuery Migrate
- Remove emojis não utilizados
- Limpeza do `<head>` do WordPress
- Resource hints (preconnect, prefetch)
- Dimensões explícitas em imagens (previne CLS)
- Critical CSS inline (opcional)

### Structured Data
- Product schema (JSON-LD)
- BreadcrumbList schema
- Organization schema

### Core Web Vitals
- LCP otimizado com preload de imagens hero
- FID minimizado com JS defer/async
- CLS prevenido com dimensões explícitas

---

## 🔧 Configuração

### Requisitos
- WordPress 6.4 ou superior
- PHP 8.0 ou superior
- WooCommerce 8.0+ (recomendado)

### Instalação
1. Faça upload da pasta `iron-task` para `/wp-content/themes/`
2. Ative o tema em **Aparência > Temas**
3. Instale e ative o plugin WooCommerce
4. Configure os menus em **Aparência > Menus**
5. Adicione widgets em **Aparência > Widgets**

### Menus Disponíveis
- **Menu Principal**: Navbar desktop
- **Menu Mobile**: Menu mobile
- **Menu Rodapé**: Links do footer
- **Menu Secundário**: Uso geral

### Sidebars Registradas
- Sidebar Principal
- Footer Colunas 1-4
- Shop Sidebar

---

## 🌐 Tradução

O tema está preparado para tradução (text domain: `iron-task`).

Para gerar o arquivo `.pot`:
```bash
wp i18n make-pot . languages/iron-task.pot
```

Traduções disponíveis:
- Português do Brasil (padrão)
- Inglês (via .po/.mo files)

---

## 📱 Responsividade

Breakpoints:
- Mobile: < 768px
- Tablet: 768px - 1023px
- Desktop: ≥ 1024px

Grid de produtos:
- Mobile: 1 coluna
- Tablet: 2 colunas
- Desktop: 4 colunas

---

## 🎯 Próximos Passos (Extensões Futuras)

1. **Customizer Options**
   - Cores personalizadas
   - Upload de logo
   - Configuração de redes sociais
   - Toggle de features

2. **Gutenberg Blocks**
   - Block de produtos em destaque
   - Block de categorias
   - Block de testimonials
   - Block CTA

3. **Demo Content**
   - XML import file
   - Imagens de demonstração
   - Widgets pré-configurados

4. **Child Theme**
   - Estrutura para customizações
   - Documentação específica

---

## 📄 Licença

GNU General Public License v2 ou posterior.

---

## 👨‍💻 Desenvolvedor

Tema desenvolvido seguindo as melhores práticas do WordPress e WooCommerce, com foco em performance, acessibilidade e experiência do usuário.

**Versão:** 1.0.0  
**Última atualização:** 2026
