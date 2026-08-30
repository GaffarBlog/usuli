import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'

const toolbarSvg = {
    bold: '<path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>',
    italic: '<line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/>',
    underline: '<path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/>',
    h1: '<path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="m17 12 3-2v8"/>',
    h2: '<path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M21.5 18H14a3 3 0 0 0-3 3c0 1.1.9 2 2 2h5.5"/>',
    h3: '<path d="M4 12h8"/><path d="M4 18V6"/><path d="M12 18V6"/><path d="M17.5 18H14a3 3 0 0 0 0 6h3.5"/>',
    ul: '<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>',
    ol: '<line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>',
    quote: '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3z"/>',
    code: '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
    link: '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
    image: '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>',
    alignLeft: '<line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/>',
    alignCenter: '<line x1="18" y1="10" x2="6" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="18" y1="18" x2="6" y2="18"/>',
    alignRight: '<line x1="21" y1="10" x2="7" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="7" y2="18"/>',
    hr: '<line x1="2" y1="12" x2="22" y2="12"/>',
    undo: '<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>',
    redo: '<polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>',
}

function svgIcon(name, size = 16) {
    return `<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${toolbarSvg[name]}</svg>`
}

function createBtn(editor, name, action, tooltip) {
    const btn = document.createElement('button')
    btn.type = 'button'
    btn.innerHTML = svgIcon(name)
    btn.title = tooltip
    btn.className = 'grid h-8 w-8 place-items-center rounded text-faint transition-colors hover:bg-brand/10 hover:text-brand'
    btn.addEventListener('click', (e) => {
        e.preventDefault()
        action()
        editor.chain().focus().run()
    })
    return btn
}

function createSep() {
    const sep = document.createElement('span')
    sep.className = 'mx-1 h-5 w-px bg-hairline'
    sep.setAttribute('aria-hidden', 'true')
    return sep
}

function buildToolbar(editor, container) {
    const groups = [
        [
            createBtn(editor, 'bold', () => editor.chain().focus().toggleBold().run(), 'বোল্ড'),
            createBtn(editor, 'italic', () => editor.chain().focus().toggleItalic().run(), 'ইটালিক'),
            createBtn(editor, 'underline', () => editor.chain().focus().toggleUnderline().run(), 'আন্ডারলাইন'),
        ],
        [
            createBtn(editor, 'h1', () => editor.chain().focus().toggleHeading({ level: 1 }).run(), 'শিরোনাম ১'),
            createBtn(editor, 'h2', () => editor.chain().focus().toggleHeading({ level: 2 }).run(), 'শিরোনাম ২'),
            createBtn(editor, 'h3', () => editor.chain().focus().toggleHeading({ level: 3 }).run(), 'শিরোনাম ৩'),
        ],
        [
            createBtn(editor, 'ul', () => editor.chain().focus().toggleBulletList().run(), 'তালিকা'),
            createBtn(editor, 'ol', () => editor.chain().focus().toggleOrderedList().run(), 'ক্রমিক তালিকা'),
            createBtn(editor, 'quote', () => editor.chain().focus().toggleBlockquote().run(), 'উদ্ধৃতি'),
            createBtn(editor, 'code', () => editor.chain().focus().toggleCodeBlock().run(), 'কোড'),
        ],
        [
            createBtn(editor, 'link', () => {
                const url = window.prompt('লিংক URL লিখুন:', editor.getAttributes('link').href || '')
                if (url === null) return
                if (url === '') {
                    editor.chain().focus().unsetLink().run()
                } else {
                    editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run()
                }
            }, 'লিংক'),
            createBtn(editor, 'image', () => {
                const url = window.prompt('ছবির URL লিখুন:')
                if (url) editor.chain().focus().setImage({ src: url }).run()
            }, 'ছবি'),
            createBtn(editor, 'hr', () => editor.chain().focus().setHorizontalRule().run(), 'বিভাজক'),
        ],
        [
            createBtn(editor, 'alignLeft', () => editor.chain().focus().setTextAlign('left').run(), 'বাম পাশ'),
            createBtn(editor, 'alignCenter', () => editor.chain().focus().setTextAlign('center').run(), 'মাঝ বরাবর'),
            createBtn(editor, 'alignRight', () => editor.chain().focus().setTextAlign('right').run(), 'ডান পাশ'),
        ],
        [
            createBtn(editor, 'undo', () => editor.chain().focus().undo().run(), 'আনডু'),
            createBtn(editor, 'redo', () => editor.chain().focus().redo().run(), 'রিডু'),
        ],
    ]

    groups.forEach((buttons, i) => {
        buttons.forEach((btn) => container.appendChild(btn))
        if (i < groups.length - 1) container.appendChild(createSep())
    })
}

window.initTipTap = function (selector, content = '') {
    const el = document.querySelector(selector)
    if (!el) return null

    const hiddenInput = document.createElement('input')
    hiddenInput.type = 'hidden'
    hiddenInput.name = el.dataset.name || 'content'
    hiddenInput.value = content
    el.parentNode.appendChild(hiddenInput)

    const toolbar = document.createElement('div')
    toolbar.className = 'flex flex-wrap items-center gap-0.5 border-b border-hairline bg-gray-50/60 px-3 py-2'
    el.parentNode.insertBefore(toolbar, el)

    const editor = new Editor({
        element: el,
        extensions: [
            StarterKit.configure({
                heading: { levels: [1, 2, 3] },
            }),
            Placeholder.configure({
                placeholder: 'লেখার বিষয়বস্তু লিখুন...',
            }),
            Underline,
            TextAlign.configure({
                types: ['heading', 'paragraph'],
            }),
            Image.configure({
                inline: true,
                allowBase64: true,
            }),
            Link.configure({
                openOnClick: false,
                HTMLAttributes: { class: 'text-brand-deep underline' },
            }),
        ],
        content: content,
        editorProps: {
            attributes: {
                class: 'tiptap focus:outline-none',
            },
        },
        onUpdate: ({ editor: e }) => {
            hiddenInput.value = e.getHTML()
        },
    })

    buildToolbar(editor, toolbar)
    hiddenInput.value = editor.getHTML()

    window.admin = window.admin || {}
    window.admin.editor = editor

    return editor
}
