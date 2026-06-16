@props(['page', 'slug', 'label', 'placeholder' => '', 'previewUrl' => null])

<form method="POST" action="{{ route('admin.pages.update', $slug) }}" class="mt-6 space-y-5">
    @csrf
    @method('PUT')

    <x-card>
        <div class="space-y-4">
            <div>
                <x-label for="{{ $slug }}-title" value="Page title" required />
                <x-input
                    id="{{ $slug }}-title"
                    name="title"
                    :value="$page->title"
                    required
                />
                <x-input-error for="title" />
                <p class="mt-1 text-xs text-ink-500">Shown as the page heading and browser tab title.</p>
            </div>

            <div>
                <x-label for="{{ $slug }}-content" value="Content" />
                <textarea
                    id="{{ $slug }}-content"
                    name="content"
                    rows="14"
                    class="input"
                    placeholder="{{ $placeholder }}"
                >{{ old('content', $page->content) }}</textarea>
                <x-input-error for="content" />
            </div>

            <label class="flex cursor-pointer items-center gap-2 text-sm text-ink-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page->is_active))
                       class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500">
                Visible on the website
            </label>
        </div>
    </x-card>

    <div class="flex items-center justify-between">
        @if($previewUrl)
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="text-sm font-medium text-brand-600 hover:text-brand-700">
                Preview on site →
            </a>
        @else
            <span></span>
        @endif
        <button type="submit" class="btn btn-primary">Save {{ $label }}</button>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor.create(document.querySelector('#{{ $slug }}-content'), {
        toolbar: [
            'heading',
            '|',
            'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript',
            'link', 'blockQuote', 'codeBlock',
            'bulletedList', 'numberedList', 'todoList',
            '|',
            'alignment', 'outdent', 'indent',
            '|',
            'fontColor', 'fontBackgroundColor', 'fontSize', 'fontFamily',
            '|',
            'insertTable', 'imageUpload', 'mediaEmbed', 'horizontalLine', 'pageBreak',
            '|',
            'undo', 'redo', 'removeFormat', 'highlight', 'specialCharacters'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        fontFamily: {
            options: [
                'default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
            ]
        },
        fontSize: { options: [ 'tiny', 'small', 'default', 'big', 'huge' ] },
        alignment: { options: [ 'left', 'center', 'right', 'justify' ] }
    })
    .catch(function (error) { console.error(error); });
});
</script>
