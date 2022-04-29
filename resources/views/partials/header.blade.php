<nav class="bg-black shadow-lg">
    <div class="mx-8 px-3">
        <div class="flex justify-between">
               <div class="flex space-x-7">
                   <!--Website Logo-->
                    <a href="{{route('reupload')}}" class="flex text-xl font-extrabold text-primary-red items-center py-2 px-2">
                        Full Force Financial
                    </a>
               </div>
               <div class="hidden md:flex items-center space-x-1">
                    <a href="{{route('reupload')}}" class="{{ (request()->is('reupload')) ? 'border-b-4' : '' }} hover:border-b-4 py-2 px-2 text-white border-secondary-blue font-semibold">
                        Upload
                    </a>
                    <a href="{{route('editdata')}}" class="{{ (request()->is('editdata')) ? 'border-b-4' : '' }} hover:border-b-4 py-2 px-2 text-white border-secondary-blue font-semibold">
                        Edit
                    </a>
                    <a href="{{route('tableView')}}" class=" {{ (request()->is('tableView')) ? 'border-b-4' : '' }} hover:border-b-4 py-2 px-2 text-white border-secondary-blue font-semibold">
                        Table View
                    </a>
                    <a href="{{route('report')}}" class="py-2 px-2 text-white hover:border-b-4 border-secondary-blue font-semibold">
                        Report
                    </a>
                    <a href="{{route('save')}}" class=" py-2 px-2 text-white font-semibold hover:border-b-4  border-secondary-blue ">
                        Save
                    </a>
                    <a href="{{route('template')}}" class="{{ (request()->is('template')) ? 'border-b-4' : '' }} hover:border-b-4 py-2 px-2 text-white border-secondary-blue font-semibold ">
                        Template
                    </a>

                </div>

                <div class="md:hidden flex items-center">
                    <button class="outline-none menu-button">
                        <svg class="w-6 h-6 text-white" x-show="! showMenu" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 00 24 24" stroke="currentColor"><path d="m4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="hidden mobile-menu">
                    <ul class="text-white">
                        <li class="active"> 
                            <a href="{{route('editdata')}}" class="block px-2 py-4 font-semibold">
                                Editing
                            </a>
                        </li>
                        <li class="active"> 
                            <a href="{{route('reupload')}}" class="block px-2 py-4 font-semibold">
                                Reupload
                            </a>
                        </li>
                        <li class=""> 
                            <a href="{{route('tableView')}}" class="block px-2 py-4 font-semibold">
                                Table View
                            </a>
                        </li>
                        
                        <li class="active"> 
                            <a href="{{route('report')}}" class="block px-2 py-4 font-semibold">
                                Report
                            </a>
                        </li>
                        <li>
                            <a href="{{route('save')}}" class="block px-2 py-4 font-semibold">
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



