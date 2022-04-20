<nav class="bg-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">
               <div class="flex space-x-7">
                   <!--Website Logo-->
                    <a href="#" class="flex text-xl font-blod text-red-600 items-center py-4 px-2">
                        Full Force Financial
                    </a>
               </div>
               <div class="hidden md:flex items-center space-x-1">
                    <a href="{{route('editdata')}}" class="{{ (request()->is('editdata')) ? 'border-b-4' : '' }} py-4 px-2 text-black-500 border-red-600 font-semibold">
                        Editing
                    </a>
                    <a href="#" onclick="downloadExcelSheet()" class="py-4 px-2 text-black-500 border-red-600 font-semibold">
                        Report
                    </a>
                    <a href="{{route('reupload')}}" class="{{ (request()->is('reupload')) ? 'border-b-4' : '' }} py-4 px-2 text-black-500 border-red-600 font-semibold">
                        Reupload
                    </a>
                    <a href="{{route('tableView')}}" class="{{ (request()->is('tableView')) ? 'border-b-4' : '' }} py-4 px-2 text-black-500 border-red-600 font-semibold">
                        Table View
                    </a>
                    <a href="{{route('save')}}" class="{{ (request()->is('save')) ? 'border-b-4' : '' }} py-4 px-2 text-black-500 font-semibold hover:text-red-600 transition duration-300">
                        Save
                    </a>
                    <a href="{{route('template')}}" class="{{ (request()->is('template')) ? 'border-b-4' : '' }} py-4 px-2 text-black-500 font-semibold hover:text-red-600 transition duration-300">
                        Template
                    </a>

                </div>

                <div class="md:hidden flex items-center">
                    <button class="outline-none menu-button">
                        <svg class="w-6 h-6 text-black-500" x-show="! showMenu" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 00 24 24" stroke="currentColor"><path d="m4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="hidden mobile-menu">
                    <ul class="">
                        <li class="active"> 
                            <a href="#" class="block text-sm px-2 py-4 text-white bg-purple-500 font-semibold">
                                Editing
                            </a>
                        </li>
                        <li class="active"> 
                            <a href="#" onclick="downloadExcelSheet()" class="block text-sm px-2 py-4 text-white bg-purple-500 font-semibold">
                                Report
                            </a>
                        </li>
                        <li class="active"> 
                            <a href="{{route('reupload')}}" class="block text-sm px-2 py-4 text-white bg-purple-500 font-semibold">
                                Reupload
                            </a>
                        </li>
                        <li class=""> 
                            <a href="{{route('tableView')}}" class="block text-sm px-2 py-4 text-white bg-purple-500 font-semibold">
                                Table View
                            </a>
                        </li>
                        <li>
                            <a href="{{route('save')}}" class="block.text-sm.px-2.py-4 hover:bg-purple-500 transition duration-300">
                                Save
                            </a>
                        </li>
                    </ul>
                </div>

        </div>

    </div>
</nav>

<script>
    const btn = document.querySelector('button.menu-button');
    const menu = document.querySelector(".mobile-menu");
    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    })
</script>



