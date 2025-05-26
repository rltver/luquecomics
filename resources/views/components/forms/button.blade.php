<button {{$attributes->merge(['class'=>'bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-xs transition flex items-center justify-center gap-2 cursor-pointer','type'=>'submit'])}}>
 {{$slot}}
</button>
