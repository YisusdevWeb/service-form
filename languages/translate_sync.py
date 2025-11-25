#!/usr/bin/env python3
"""
PO Translation Synchronizer

Fills missing msgstr entries in PO files for es_ES and pt_PT
using the existing l10n PHP dictionaries, and generates .mo files.

Usage examples (run from plugin root or languages folder):
  python languages/translate_sync.py --locales es_ES pt_PT
  python languages/translate_sync.py --locale es_ES --save-mo

Requires: polib (pip install polib)
"""
import os
import re
import argparse
from typing import Dict, List

try:
    import polib
except ImportError:
    polib = None


def find_languages_dir(start_dir: str) -> str:
    """Resolve the languages directory from various run locations."""
    candidates = [
        os.path.join(start_dir, 'languages'),
        start_dir
    ]
    for p in candidates:
        if os.path.isdir(p) and os.path.exists(os.path.join(p, 'funnel-services-form.pot')):
            return p
    # fallback to start_dir
    return start_dir


def parse_l10n_php(l10n_path: str) -> Dict[str, str]:
    """Extract the messages dictionary from the l10n PHP file.

    We look for the `messages` array and parse 'key' => 'value' pairs.
    Assumes single-quoted keys and values.
    """
    with open(l10n_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find messages array
    m = re.search(r"[\"']messages[\"']\s*=>\s*\[(.*?)\]", content, re.S)
    if not m:
        raise RuntimeError(f"No messages array found in {l10n_path}")
    block = m.group(1)

    # Match pairs like 'Key' => 'Value'
    # Handles escaped quotes minimally.
    pairs = re.findall(r"'([^']+)'\s*=>\s*'([^']*)'", block)
    return {k: v for k, v in pairs}


def sync_po(po_path: str, dict_msgs: Dict[str, str]) -> Dict[str, int]:
    """Fill empty msgstr using dict_msgs. Returns stats."""
    if polib is None:
        raise RuntimeError('polib not installed. Run: python -m pip install polib')

    po = polib.pofile(po_path)
    empties_before = 0
    filled = 0

    for entry in po:
        if entry.msgid == '':
            # Header
            continue
        if (entry.msgstr or '').strip() == '':
            empties_before += 1
            tr = dict_msgs.get(entry.msgid)
            if tr:
                entry.msgstr = tr
                filled += 1

    po.save(po_path)
    return {'empties_before': empties_before, 'filled': filled}


def save_mo(po_path: str, mo_path: str) -> None:
    if polib is None:
        raise RuntimeError('polib not installed. Run: python -m pip install polib')
    po = polib.pofile(po_path)
    po.save_as_mofile(mo_path)


def main(argv: List[str] = None) -> None:
    parser = argparse.ArgumentParser(description='Synchronize PO files with l10n dictionaries.')
    parser.add_argument('--locale', dest='locale', help='Single locale (es_ES or pt_PT)')
    parser.add_argument('--locales', nargs='*', dest='locales', help='List of locales to process')
    parser.add_argument('--save-mo', action='store_true', help='Also generate .mo files')
    args = parser.parse_args(argv)

    start_dir = os.getcwd()
    lang_dir = find_languages_dir(start_dir)

    locales = []
    if args.locale:
        locales = [args.locale]
    elif args.locales:
        locales = args.locales
    else:
        locales = ['es_ES', 'pt_PT']

    for loc in locales:
        po_path = os.path.join(lang_dir, f'funnel-services-form-{loc}.po')
        l10n_path = os.path.join(lang_dir, f'funnel-services-form-{loc}.l10n.php')
        mo_path = os.path.join(lang_dir, f'funnel-services-form-{loc}.mo')

        if not os.path.exists(po_path):
            print(f'[WARN] PO not found: {po_path}')
            continue
        if not os.path.exists(l10n_path):
            print(f'[WARN] l10n not found: {l10n_path}')
            continue

        print(f'Processing {loc}...')
        dict_msgs = parse_l10n_php(l10n_path)
        # Create normalized key mapping by stripping leading emoji/symbols from keys
        norm_map: Dict[str, str] = {}
        for k, v in dict_msgs.items():
            nk = re.sub(r'^[^A-Za-z0-9]+\s*', '', k)
            nv = re.sub(r'^[^A-Za-z0-9]+\s*', '', v)
            if nk and nk not in dict_msgs:
                norm_map[nk] = nv
        # prefer exact keys when present
        dict_msgs = {**norm_map, **dict_msgs}
        # Supplemental dictionary to cover admin + ACF messages not present in l10n
        if loc == 'es_ES':
            supplement = {
                'ACF Pro': 'ACF Pro',
                'Actions': 'Acciones',
                'Advanced Custom Fields (ACF)': 'Campos Personalizados Avanzados (ACF)',
                'All User Information': 'Toda la Información de Usuario',
                'and': 'y',
                'Attention!': '¡Atención!',
                'Back': 'Volver',
                'Corporate Blue': 'Azul Corporativo',
                'Debug / Logs': 'Depuración / Registros',
                'Enable debug/logs mode': 'Activar modo debug/logs',
                'Export Selected': 'Exportar Seleccionados',
                'Dark (Default)': 'Oscuro (Predeterminado)',
                'Elegant Purple': 'Púrpura Elegante',
                'Light': 'Claro',
                'Natural Green': 'Verde Natural',
                'Warm Orange': 'Naranja Cálido',
                'Email': 'Correo electrónico',
                'Email *': 'Correo electrónico *',
                'Email Body': 'Cuerpo del Email',
                'Email Recipient': 'Destinatario del Email',
                'Email Sender': 'Remitente del Email',
                'Email is required': 'El email es obligatorio',
                'Enter a valid email': 'Introduce un email válido',
                'Enter a valid WhatsApp': 'Introduce un WhatsApp válido',
                'Fill in the fields below to request your quote!': '¡Completa los campos para solicitar tu cotización!',
                'Filter Services List': 'Filtrar lista de Servicios',
                'Full page template for services form': 'Plantilla de página completa para formulario de servicios',
                'I have read and accept': 'He leído y acepto',
                'Main Background': 'Fondo Principal',
                'Main Text': 'Texto Principal',
                'Must be at least 3 characters': 'Debe tener al menos 3 caracteres',
                'Name': 'Nombre',
                'Name and Last Name *': 'Nombre y Apellido *',
                'Name is required': 'El nombre es obligatorio',
                'Personalization of Styles and Logo': 'Personalización de Estilos y Logo',
                'Personalize all texts of the initial form': 'Personaliza todos los textos del formulario inicial',
                'Phone': 'Teléfono',
                'QUOTE REQUEST': 'SOLICITUD DE COTIZACIÓN',
                'REQUEST QUOTE': 'SOLICITAR COTIZACIÓN',
                'Save Settings': 'Guardar configuración',
                'Service Form': 'Formulario de Servicio',
                'Services Information': 'Información de Servicios',
                'Services Quote': 'Cotización de Servicios',
                'Settings saved.': 'Configuración guardada.',
                'Settings updated successfully!': '¡Configuración actualizada correctamente!',
                'Texts of the Form': 'Textos del Formulario',
                'the Privacy Policy': 'la Política de Privacidad',
                'There was an error creating the entry.': 'Hubo un error al crear la entrada.',
                'You must accept the privacy policy': 'Debe aceptar la política de privacidad',
                'Your best email': 'Tu mejor email',
                'Your First and Last Name': 'Tu nombre y apellido',
                'Your WhatsApp': 'Tu WhatsApp',
                'Your WhatsApp *': 'Tu WhatsApp *',
                'Your WhatsApp is required': 'Tu WhatsApp es obligatorio',
                '¿Restore default colors?': '¿Restaurar colores predeterminados?',
                '¿Restore default texts?': '¿Restaurar textos predeterminados?',
                '🚀 Full Screen Form': '🚀 Formulario a Pantalla Completa',
                '🚀 Full Screen Form (Plugin)': '🚀 Formulario a Pantalla Completa (Plugin)',
                'Insufficient permissions to perform this action.': 'Permisos insuficientes para realizar esta acción.',
                'Invalid post ID': 'ID de entrada inválido',
                'Invalid post.': 'Entrada inválida',
                'No services selected.': 'No hay servicios seleccionados.',
                'Post not found': 'Entrada no encontrada',
                'Privacy Policy Link Settings': 'Configuración del Enlace de Política de Privacidad',
                'Privacy Policy URL': 'URL de la Política de Privacidad',
                'Remove Selected': 'Eliminar Seleccionados',
                'Selected Services': 'Servicios Seleccionados',
                'Show logs and errors on frontend': 'Mostrar logs y errores en el frontend',
                'Thank You Page Link': 'Enlace de Página de Agradecimiento',
                'Thank You Page Link Settings': 'Configuración del Enlace de Agradecimiento',
                'Thank You Page URL': 'URL de la Página de Agradecimiento',
                'This plugin requires': 'Este plugin requiere',
                'to be installed and active to function properly, including repeater fields functionality.': 'que estén instalados y activos para funcionar correctamente, incluyendo la funcionalidad de campos repetidores.',
                'Install them to take advantage of all plugin features!': '¡Instálalos para aprovechar todas las funciones del plugin!',
                'User Data': 'Datos del Usuario',
                'User Details': 'Detalles del Usuario',
                'View': 'Ver',
                'Delete': 'Eliminar',
                'Are you sure you want to delete the selected users?': '¿Seguro que desea eliminar los usuarios seleccionados?',
                'Are you sure you want to delete this user?': '¿Seguro que desea eliminar este usuario?'
            }
            dict_msgs = {**supplement, **dict_msgs}
        elif loc == 'pt_PT':
            supplement = {
                'ACF Pro': 'ACF Pro',
                'Actions': 'Ações',
                'Advanced Custom Fields (ACF)': 'Campos Personalizados Avançados (ACF)',
                'All User Information': 'Toda a Informação do Utilizador',
                'and': 'e',
                'Attention!': 'Atenção!',
                'Back': 'Voltar',
                'Corporate Blue': 'Azul Corporativo',
                'Debug / Logs': 'Depuração / Registos',
                'Enable debug/logs mode': 'Ativar modo de depuração/registos',
                'Export Selected': 'Exportar Selecionados',
                'Dark (Default)': 'Escuro (Padrão)',
                'Elegant Purple': 'Roxo Elegante',
                'Light': 'Claro',
                'Natural Green': 'Verde Natural',
                'Warm Orange': 'Laranja Quente',
                'Email': 'E-mail',
                'Email *': 'E-mail *',
                'Email Body': 'Corpo do E-mail',
                'Email Recipient': 'Destinatário do E-mail',
                'Email Sender': 'Remetente do E-mail',
                'Email is required': 'E-mail é obrigatório',
                'Enter a valid email': 'Introduza um e-mail válido',
                'Enter a valid WhatsApp': 'Introduza um WhatsApp válido',
                'Fill in the fields below to request your quote!': 'Preencha os campos para solicitar o seu orçamento!',
                'Filter Services List': 'Filtrar lista de Serviços',
                'Full page template for services form': 'Modelo de página completa para formulário de serviços',
                'I have read and accept': 'Li e aceito',
                'Main Background': 'Fundo Principal',
                'Main Text': 'Texto Principal',
                'Must be at least 3 characters': 'Deve ter pelo menos 3 caracteres',
                'Name': 'Nome',
                'Name and Last Name *': 'Nome e Apelido *',
                'Name is required': 'O nome é obrigatório',
                'Personalization of Styles and Logo': 'Personalização de Estilos e Logotipo',
                'Personalize all texts of the initial form': 'Personalize todos os textos do formulário inicial',
                'Phone': 'Telefone',
                'QUOTE REQUEST': 'PEDIDO DE ORÇAMENTO',
                'REQUEST QUOTE': 'SOLICITAR ORÇAMENTO',
                'Save Settings': 'Guardar definições',
                'Service Form': 'Formulário de Serviço',
                'Services Information': 'Informação de Serviços',
                'Services Quote': 'Orçamento de Serviços',
                'Settings saved.': 'Definições guardadas.',
                'Settings updated successfully!': 'Definições atualizadas com sucesso!',
                'Texts of the Form': 'Textos do Formulário',
                'the Privacy Policy': 'a Política de Privacidade',
                'There was an error creating the entry.': 'Ocorreu um erro ao criar a entrada.',
                'You must accept the privacy policy': 'Deve aceitar a política de privacidade',
                'Your best email': 'O seu melhor e-mail',
                'Your First and Last Name': 'O seu nome e apelido',
                'Your WhatsApp': 'O seu WhatsApp',
                'Your WhatsApp *': 'O seu WhatsApp *',
                'Your WhatsApp is required': 'O seu WhatsApp é obrigatório',
                '¿Restore default colors?': 'Restaurar cores predefinidas?',
                '¿Restore default texts?': 'Restaurar textos predefinidos?',
                '🚀 Full Screen Form': '🚀 Formulário em Ecrã Inteiro',
                '🚀 Full Screen Form (Plugin)': '🚀 Formulário em Ecrã Inteiro (Plugin)',
                'Insufficient permissions to perform this action.': 'Permissões insuficientes para realizar esta ação.',
                'Invalid post ID': 'ID de publicação inválido',
                'Invalid post.': 'Publicação inválida',
                'No services selected.': 'Nenhum serviço selecionado.',
                'Post not found': 'Publicação não encontrada',
                'Privacy Policy Link Settings': 'Configuração do Link da Política de Privacidade',
                'Privacy Policy URL': 'URL da Política de Privacidade',
                'Remove Selected': 'Eliminar Selecionados',
                'Selected Services': 'Serviços Selecionados',
                'Show logs and errors on frontend': 'Mostrar registos e erros no frontend',
                'Thank You Page Link': 'Link da Página de Agradecimento',
                'Thank You Page Link Settings': 'Configuração do Link da Página de Agradecimento',
                'Thank You Page URL': 'URL da Página de Agradecimento',
                'This plugin requires': 'Este plugin requer',
                'to be installed and active to function properly, including repeater fields functionality.': 'que estejam instalados e ativos para funcionar corretamente, incluindo a funcionalidade de campos repetidores.',
                'Install them to take advantage of all plugin features!': 'Instale-os para aproveitar todas as funcionalidades do plugin!',
                'User Data': 'Dados do Utilizador',
                'User Details': 'Detalhes do Utilizador',
                'View': 'Ver',
                'Delete': 'Eliminar',
                'Are you sure you want to delete the selected users?': 'Tem certeza de que deseja eliminar os utilizadores selecionados?',
                'Are you sure you want to delete this user?': 'Tem certeza de que deseja eliminar este utilizador?'
            }
            dict_msgs = {**supplement, **dict_msgs}

        stats = sync_po(po_path, dict_msgs)
        print(f' - Empty msgstr before: {stats["empties_before"]}')
        print(f' - Filled entries: {stats["filled"]}')

        if args.save_mo:
            save_mo(po_path, mo_path)
            print(f' - Saved MO: {mo_path}')

    print('Done.')


if __name__ == '__main__':
    main()
