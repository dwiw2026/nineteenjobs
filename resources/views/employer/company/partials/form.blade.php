@php
    $field = $company ?? null;
@endphp
<div class="space-y-4">
    {{-- Logo --}}
    <div>
        <label class="block text-sm font-semibold text-[#19251d]">Logo</label>
        <div class="mt-2 flex items-center gap-4">
            <img src="{{ $field?->logo_url ?? 'https://ui-avatars.com/api/?name=|&background=b7f34a&color=182516&size=128' }}"
                 alt="Logo"
                 class="h-20 w-20 rounded-xl object-cover border border-[#e1e9df]">
            <div class="flex-1">
                <input type="file"
                       name="logo"
                       accept="image/*"
                       class="block w-full text-sm text-[#19251d] file:mr-4 file:rounded-xl file:border-0 file:bg-[#b7f34a] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#12210d] hover:file:bg-[#a5e33a]">
                @if($field?->logo)
                    <p class="mt-1 text-xs text-[#89958b]">Klik untuk mengganti logo(현재: {{ basename($field->logo) }})</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Nama --}}
    <div>
        <label for="name" class="block text-sm font-semibold text-[#19251d]">Nama Perusahaan <span class="text-red-500">*</span></label>
        <input type="text"
               id="name"
               name="name"
               value="{{ old('name', $field?->name) }}"
               required
               class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30 @[22@w:filepath:C:/laragon/www/nineteenjobs/resources/views/employer/company/create.blade.php]invalid:border-red-400 @[22@w:filepath:C:/laragon/www/nineteenjobs/resources/views/employer/company/create.blade.php]">
        @error('name')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tagline --}}
    <div>
        <label for="tagline" class="block text-sm font-semibold text-[#19251d]">Tagline</label>
        <input type="text"
               id="tagline"
               name="tagline"
               value="{{ old('tagline', $field?->tagline) }}"
               maxlength="255"
               class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        @error('tagline')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Website --}}
    <div>
        <label for="website" class="block text-sm font-semibold text-[#19251d]">Website</label>
        <input type="url"
               id="website"
               name="website"
               value="{{ old('website', $field?->website) }}"
               placeholder="https://contoh.com"
               class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        @error('website')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Industry --}}
    <div>
        <label for="industry" class="block text-sm font-semibold text-[#19251d]">Industri</label>
        <input type="text"
               id="industry"
               name="industry"
               value="{{ old('industry', $field?->industry) }}"
               placeholder="Misal: Teknologi, Pendidikan, Manufaktur"
               class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        @error('industry')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Size --}}
    <div>
        <label for="size" class="block text-sm font-semibold text-[#19251d]">Ukuran Perusahaan</label>
        <select id="size" name="size" class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
            <option value="">Pilih ukuran</option>
            <option value="startup" {{ old('size', $field?->size) === 'startup' ? 'selected' : '' }}>Startup (≤ 10 karyawan)</option>
            <option value="small" {{ old('size', $field?->size) === 'small' ? 'selected' : '' }}>UMKM / Kecil (11–50 karyawan)</option>
            <option value="medium" {{ old('size', $field?->size) === 'medium' ? 'selected' : '' }}>Menengah (51–200 karyawan)</option>
            <option value="large" {{ old('size', $field?->size) === 'large' ? 'selected' : '' }}>Besar (201–1000 karyawan)</option>
            <option value="enterprise" {{ old('size', $field?->size) === 'enterprise' ? 'selected' : '' }}>Enterprise (> 1000 karyawan)</option>
        </select>
        @error('size')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Location --}}
    <div>
        <label for="location" class="block text-sm font-semibold text-[#19251d]">Lokasi / Kantor</label>
        <input type="text"
               id="location"
               name="location"
               value="{{ old('location', $field?->location) }}"
               placeholder="Misal: Jakarta, Indonesia"
               class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30">
        @error('location')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="block text-sm font-semibold text-[#19251d]">Tentang Perusahaan</label>
        <textarea id="description"
                  name="description"
                  rows="5"
                  class="mt-1 block w-full rounded-xl border border-[#cbd5cf] bg-white px-4 py-2.5 text-sm text-[#19251d placeholder:text-[#a0aaa1] focus:border-[#b7f34a] focus:outline-none focus:ring-2 focus:ring-[#b7f34a]/30"
                  placeholder="Ceritakan tentang perusahaan, budaya kerja, misi, dan hal menarik lainnya...">{{ old('description', $field?->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>
