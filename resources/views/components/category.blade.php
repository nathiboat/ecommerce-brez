<div class="ml-4">
    
    <a href="/categories/{{ $category->slug }}" class="{{ $category->depth === 0 ? 'font-bold': '' }}">{{ $category->title }}</a>
  
    @foreach ($category->children as $child) 
        <div class="ml-4">
            <x-category :category="$child" />
        </div> 
    @endforeach
  
</div>