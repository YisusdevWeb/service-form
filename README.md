# EWEB - Funnel Services Form

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-purple.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-GPLv3-green.svg)](http://www.gnu.org/licenses/gpl-3.0.html)
[![Version](https://img.shields.io/badge/Version-1.4.2-orange.svg)](https://github.com/Yisus-Develop)

Plugin de formulário de serviços com etapas (steps) para cotações. Permite criar formulários de múltiplas fases com personalização de cores e estilos.

## 📋 Requisitos

- **WordPress:** 6.0 ou superior
- **PHP:** 8.1 ou superior
- **Testado até:** WordPress 6.4
- **ACF Pro:** Requerido para campos personalizados

## 🚀 Instalação

1. Faça o download do plugin
2. Extraia na pasta `/wp-content/plugins/`
3. Execute os comandos de build:

```bash
cd wp-content/plugins/services-form
npm install
npm run build
```

4. Ative o plugin no painel do WordPress

## 🌍 Internacionalização (i18n)

O plugin está **100% preparado para traduções**:

- ✅ **Text Domain:** `funnel-services-form`
- ✅ **Domain Path:** `/languages/`
- ✅ Funções de tradução `__()` e `_e()` implementadas
- ✅ Arquivo `.pot` incluído em `/languages/`

### Como traduzir

1. Copie o arquivo `languages/funnel-services-form.pot`
2. Renomeie para `funnel-services-form-{LOCALE}.po` (ex: `funnel-services-form-es_ES.po`)
3. Traduza usando [Poedit](https://poedit.net/) ou similar
4. Salve para gerar o arquivo `.mo`
5. Coloque ambos arquivos na pasta `/languages/`

### Locales suportados

- `pt_BR` - Português (Brasil) - Padrão
- `es_ES` - Español
- `en_US` - English

## 🎨 Funcionalidades

### Formulário Multi-Fases
- Navegação inteligente por fases
- Seleção única ou múltipla por fase
- Validação de campos em tempo real
- Proteção CSRF com nonce

### Personalização Visual
- 6 templates de cores predefinidos:
  - 🌙 Escuro (Padrão)
  - ☀️ Claro
  - 🔵 Azul Corporativo
  - 🟢 Verde Natural
  - 🟣 Púrpura Elegante
  - 🟠 Laranja Quente
- Upload de logo personalizado
- Glassmorphism design
- Cores totalmente customizáveis
- **Dashboard admin moderno** com design profissional

### Textos Personalizáveis (Novo! v1.4.2)
- Editar todos os textos do formulário inicial desde o admin
- Títulos e subtítulos personalizáveis
- Labels e placeholders dos campos (Nome, Email, WhatsApp)
- Mensagens de erro customizáveis
- Texto do botão de envio
- Textos de política de privacidade

### Template Full Screen
- Página dedicada para o formulário
- Sem conflitos com Elementor/builders
- Fundo gradiente personalizável

### E-mails Automáticos
- Notificação ao admin (lead)
- Cotação para o usuário
- Templates HTML personalizáveis

## 📁 Estrutura do Plugin

```
services-form/
├── funil-services-form.php    # Bootstrap principal
├── app/                       # Frontend React
│   ├── components/            # Componentes UI
│   ├── form/                  # Formulários
│   ├── store/                 # Estado (Zustand)
│   └── utils/                 # Utilitários
├── assets/                    # CSS/SCSS/JS
├── dist/                      # Build compilado
├── includes/                  # Lógica PHP
│   ├── acf/                   # Campos ACF
│   ├── admin/                 # Panel de administração
│   │   ├── js/                # Scripts JS separados
│   │   │   ├── styles-admin.js
│   │   │   └── form-texts-admin.js
│   │   ├── views/             # Vistas HTML
│   │   │   ├── styles-settings-page.php
│   │   │   └── form-texts-page.php
│   │   ├── color-templates.php
│   │   ├── frontend-styles.php
│   │   ├── styles-admin.php
│   │   └── form-texts-admin.php
│   ├── compat/                # Compatibilidad con temas
│   ├── templates/             # Templates de página
│   └── *.php                  # Módulos
└── languages/                 # Traduções
    └── funnel-services-form.pot
```

## 🔧 Desenvolvimento

### Build para produção
```bash
npm run build
```

### Build em modo watch
```bash
npm run watch
```

## 📝 Changelog

### v1.4.2 (Nov 2025)
- **Novo:** Panel de edição de textos do formulário (`Textos do Formulário`)
- **Novo:** Textos 100% personalizáveis (títulos, labels, placeholders, erros, botões)
- **Melhoria:** Dashboard admin com design moderno e profissional
- **Melhoria:** Scripts JS separados em arquivos externos (`/includes/admin/js/`)
- **Melhoria:** Código mais limpo sem scripts inline
- **Melhoria:** Mensagem de sucesso com estilo próprio (não mais texto em branco)
- **Melhoria:** Estilos sem inline styles (melhor compatibilidade CSP)
- **Fix:** Sistema de compatibilidad con temas (`/includes/compat/`)
- **Fix:** Archivo `custom-theme-override.css` para reglas de override
- **Fix:** Constante `FSF_PLUGIN_VERSION` corrigida

### v1.4.0 (Nov 2025)
- **Refactor:** Código admin separado en módulos (`/includes/admin/`)
- **Otimização:** CSS reducido ~24% (9.77 KiB → 7.39 KiB)
- **Otimização:** SCSS reducido ~56% (~435 → ~190 líneas)
- **Melhoria:** Isolamento de Elementor sem quebrar estilos MUI
- **Melhoria:** Variables CSS centralizadas
- **Fix:** Conflitos de padding/margin com page builders
### v1.3.1 (Nov 2025)
- Selector de mídia WordPress para logo
- Botão de reset de estilos
- Valores por defeito melhorados

### v1.3.0 (Nov 2025)
- Design Glassmorphism
- Panel de personalização completo
- Sistema de cores dinâmico

### v1.2.0 (Out 2025)
- Correção do "passo fantasma"
- Validação CSRF implementada
- Melhorias na navegação

## 🗺️ Roadmap (Futuro)

### 🔜 Próximas versões

#### Independência de ACF
- [ ] Criar campos personalizados nativos sem depender de ACF Pro
- [ ] Interface de administração para criar/editar fases
- [ ] Exportar/importar configurações de formulário (JSON)
- [ ] Migração automática de dados ACF para sistema nativo

#### Traduções e i18n
- [ ] Tradução completa para Español (es_ES)
- [ ] Tradução completa para English (en_US)
- [ ] Integração com WPML/Polylang
- [ ] Tradução de strings do frontend React

#### Performance
- [ ] Lazy loading de componentes React
- [ ] Code splitting por rota/fase
- [ ] Caché de configurações (transients)
- [ ] Minificação automática de CSS inline

#### Funcionalidades
- [ ] Lógica condicional entre fases
- [ ] Campos personalizados por fase (texto, número, archivo)
- [ ] Integração con CRMs (HubSpot, Pipedrive, etc.)
- [ ] Webhooks para automatizaciones
- [ ] Dashboard de analytics (leads, conversiones)
- [ ] A/B testing de templates
- [ ] Integración con sistemas de email marketing
- [x] ~~Poder editar textos de botão (próximo, anterior, enviar)~~ ✅ v1.4.2
- [x] ~~Poder editar los campos del formulario inicial (nombre, email, teléfono)~~ ✅ v1.4.2

#### UX/UI
- [ ] Animaciones de transición entre fases
- [ ] Modo dark/light automático
- [ ] Preview en tiempo real en el admin
- [ ] Más templates de colores
- [ ] Tipografías personalizables
- [ ] Aplicar diseño moderno a todas las páginas de admin (mismo estilo de Estilos y Textos)

#### Integraciones
- [ ] WooCommerce (productos como servicios)
- [ ] Elementor widget nativo
- [ ] Gutenberg block
- [ ] Zapier/Make integration
- [ ] reCAPTCHA v3

### 💡 ¿Tienes ideas?

Abre un [issue en GitHub](https://github.com/Yisus-Develop/service-form/issues) con tu sugerencia.

## 👨‍💻 Autor

**Yisus Develop**
- GitHub: [@Yisus-Develop](https://github.com/Yisus-Develop)
- Website: [enlaweb.co](https://enlaweb.co/)

## 📄 Licença

Este plugin está licenciado sob a [GNU General Public License v3.0](http://www.gnu.org/licenses/gpl-3.0.html).
