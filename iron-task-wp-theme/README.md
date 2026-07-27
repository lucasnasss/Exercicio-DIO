# Iron Task - Tema WordPress para WooCommerce

Tema profissional para WordPress/WooCommerce inspirado em design esportivo e streetwear. Totalmente responsivo, otimizado para SEO e Core Web Vitals.

## 🚀 Características

- **Design Moderno**: Estilo dark/light theme com cores personalizáveis
- **WooCommerce Ready**: Total compatibilidade com WooCommerce
- **Responsivo**: Mobile-first, funciona em todos os dispositivos
- **Performance**: Otimizado para Core Web Vitals
- **SEO Friendly**: Estrutura semântica e acessível
- **Customizer**: Personalize cores, tema padrão e mais

## 📁 Estrutura de Arquivos

```
iron-task-wp-theme/
├── style.css              # Estilos principais + metadata do tema
├── functions.php          # Funções do tema
├── header.php             # Cabeçalho
├── footer.php             # Rodapé
├── index.php              # Template fallback
├── front-page.php         # Página inicial personalizada
├── single.php             # Posts individuais
├── page.php               # Páginas estáticas
├── archive.php            # Arquivos
├── search.php             # Resultados de busca
├── 404.php                # Página de erro 404
├── comments.php           # Comentários
├── sidebar.php            # Barra lateral
├── assets/
│   ├── js/
│   │   └── main.js        # JavaScript principal
│   ├── css/
│   └── img/
├── inc/
│   ├── customizer.php     # Configurações do Customizer
│   ├── template-functions.php
│   ├── template-tags.php
│   └── woocommerce.php    # Compatibilidade WooCommerce
├── template-parts/
└── woocommerce/
```

## 🛠️ Instalação

1. Copie a pasta `iron-task-wp-theme` para `/wp-content/themes/`
2. No admin do WordPress, vá em Aparência > Temas
3. Ative o tema "Iron Task"

## ⚙️ Configuração

### Customizer (Aparência > Personalizar)

- **Tema Padrão**: Escolha entre Escuro, Claro ou Seguir sistema
- **Cor de Destaque**: Personalize a cor principal (#C9A44B por padrão)
- **Tela de Carregamento**: Ativar/desativar loader animado
- **Frases do Manifesto**: Personalize as frases da home

### Menus

Registre menus em:
- Menu Principal (header)
- Menu Rodapé
- Menu Mobile

### Widgets

Áreas disponíveis:
- Barra Lateral
- Rodapé 1, 2, 3

## 🎨 Variáveis CSS

O tema usa CSS Custom Properties para fácil personalização:

```css
:root {
    --color-bg-primary: #0A0A0C;
    --color-bg-secondary: #12141A;
    --color-accent-primary: #C9A44B;
    --color-accent-secondary: #E85D3A;
    --navbar-height: 72px;
    /* ... mais variáveis */
}
```

## 🔌 Funcionalidades

- Loader animado com SVG
- Toggle de tema claro/escuro
- Navbar que esconde/mostra no scroll
- Menu mobile responsivo
- Animações reveal on scroll
- Toast notifications
- AJAX add to cart (WooCommerce)
- Ripple effect em botões
- Smooth scroll para âncoras

## 📱 Responsividade

Breakpoints:
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

## 🌐 Navegadores Suportados

- Chrome (últimas 2 versões)
- Firefox (últimas 2 versões)
- Safari (últimas 2 versões)
- Edge (últimas 2 versões)

## 📄 Licença

GNU General Public License v2 or later

## 👨‍💻 Desenvolvedor

Ricardo Moura - https://ricardomoura.dev

---

**Iron Task** - Forjado no fogo. Vestido com propósito.
