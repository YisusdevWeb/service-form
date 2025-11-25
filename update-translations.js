const fs = require('fs');
const path = require('path');

/**
 * Script para actualizar las cadenas de traducción en los archivos React
 * 
 * Este script convierte las cadenas de texto en los archivos React/JSX
 * para usar la función de internacionalización de WordPress
 */

// Archivos que necesitan actualizarse
const filesToUpdate = [
  'app/app.jsx',
  'app/components/Preloader.jsx',
  'app/components/SuccessMessage.jsx',
  'app/components/NoPhasePopup.jsx'
];

// Cadenas a reemplazar y sus traducciones
const stringReplacements = {
  // En app/app.jsx
  'Selecionar um serviço': {
    newText: '{translatedTexts?.service_selection || "Select a service"}',
    i18nString: 'Select a service'
  },
  
  // En Preloader.jsx
  'Carregando...': {
    newText: '{translatedTexts?.loading || "Loading..."}',
    i18nString: 'Loading...'
  },
  
  // En SuccessMessage.jsx
  'Email enviado com sucesso!': {
    newText: '{translatedTexts?.email_sent_success || "Email sent successfully!"}',
    i18nString: 'Email sent successfully!'
  },
  'Redirecionando...': {
    newText: '{translatedTexts?.redirecting || "Redirecting..."}',
    i18nString: 'Redirecting...'
  },
  
  // En NoPhasePopup.jsx
  'Aviso': {
    newText: '{translatedTexts?.notice || "Notice"}',
    i18nString: 'Notice'
  },
  'Fechar': {
    newText: '{translatedTexts?.close || "Close"}',
    i18nString: 'Close'
  }
};

function updateReactFiles() {
  const srcDir = __dirname;
  
  filesToUpdate.forEach(file => {
    const filePath = path.join(srcDir, file);
    
    if (fs.existsSync(filePath)) {
      let content = fs.readFileSync(filePath, 'utf8');
      let updated = false;
      
      // Reemplazar cadenas
      for (const [oldString, replacement] of Object.entries(stringReplacements)) {
        if (content.includes(oldString)) {
          content = content.replace(new RegExp(oldString.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), replacement.newText);
          updated = true;
          console.log(`Reemplazada cadena "${oldString}" en ${file}`);
        }
      }
      
      if (updated) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Archivo ${file} actualizado con éxito`);
      }
    } else {
      console.log(`Archivo no encontrado: ${file}`);
    }
  });
}

// Actualizar archivos PHP también
function updatePhpFiles() {
  const adminFormTextsPath = path.join(__dirname, 'includes/admin/form-texts-admin.php');
  
  if (fs.existsSync(adminFormTextsPath)) {
    let content = fs.readFileSync(adminFormTextsPath, 'utf8');
    
    // Actualizar textos predeterminados a inglés
    content = content.replace(/'form_title' => 'PEDIDO DE PROPOSTA'/, "'form_title' => 'QUOTE REQUEST'");
    content = content.replace(/'form_subtitle' => 'Preenche os campos abaixo para pedires a tua proposta!'/, "'form_subtitle' => 'Fill in the fields below to request your quote!'");
    content = content.replace(/'name_label' => 'Nome e Apelido \*'/, "'name_label' => 'Name and Last Name *'");
    content = content.replace(/'name_placeholder' => 'O teu Primeiro e último nome'/, "'name_placeholder' => 'Your First and Last Name'");
    content = content.replace(/'name_error_required' => 'Nome é obrigatório'/, "'name_error_required' => 'Name is required'");
    content = content.replace(/'name_error_min' => 'Deve ter pelo menos 3 caracteres'/, "'name_error_min' => 'Must be at least 3 characters'");
    content = content.replace(/'email_label' => 'E-mail \*'/, "'email_label' => 'Email *'");
    content = content.replace(/'email_placeholder' => 'O teu melhor e-mail'/, "'email_placeholder' => 'Your best email'");
    content = content.replace(/'email_error_required' => 'Email é obrigatório'/, "'email_error_required' => 'Email is required'");
    content = content.replace(/'email_error_invalid' => 'Insere um email válido'/, "'email_error_invalid' => 'Enter a valid email'");
    content = content.replace(/'whatsapp_label' => 'O teu WhatsApp \*'/, "'whatsapp_label' => 'Your WhatsApp *'");
    content = content.replace(/'whatsapp_placeholder' => 'O teu WhatsApp'/, "'whatsapp_placeholder' => 'Your WhatsApp'");
    content = content.replace(/'whatsapp_error_required' => 'Teu WhatsApp é obrigatório'/, "'whatsapp_error_required' => 'Your WhatsApp is required'");
    content = content.replace(/'whatsapp_error_invalid' => 'Insere teu WhatsApp válido'/, "'whatsapp_error_invalid' => 'Enter a valid WhatsApp'");
    content = content.replace(/'privacy_text' => 'Li e aceito'/, "'privacy_text' => 'I have read and accept'");
    content = content.replace(/'privacy_link_text' => 'a Política de Privacidade'/, "'privacy_link_text' => 'the Privacy Policy'");
    content = content.replace(/'privacy_error' => 'É necessário aceitar as políticas de privacidade'/, "'privacy_error' => 'You must accept the privacy policy'");
    content = content.replace(/'submit_button' => 'SOLICITAR PROPOSTA'/, "'submit_button' => 'REQUEST QUOTE'");
    content = content.replace(/'error_message' => 'Houve um erro ao criar a entrada.'/, "'error_message' => 'There was an error creating the entry.'");
    
    fs.writeFileSync(adminFormTextsPath, content, 'utf8');
    console.log('Archivo includes/admin/form-texts-admin.php actualizado con texto en inglés');
  }
}

// Ejecutar las funciones
console.log('Actualizando cadenas de traducción en el plugin...');
updatePhpFiles();
updateReactFiles();
console.log('Proceso de actualización completado. Revisa los archivos para asegurar la correcta integración.');