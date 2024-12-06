@extends('base.admin_navbar')

@section('librarycss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
@endsection

@section('content')
    <div class="pt-20">
        <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10 px-10">
            <select id="category" data-te-select-init>
                <option value="all">All Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
            <div class="w-full relative my-3 mx-5" data-twe-input-wrapper-init>
                <input type="search"
                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0 dark:autofill:shadow-autofill"
                    id="datatable-search-input" placeholder="Search" />
                <label for="datatable-search-input"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[0.9rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary">Search
                </label>
            </div>

            <div id="datatable" class="relative w-full py-5 z-[2]" data-te-fixed-header="true"></div>

        </div>
    </div>
@endsection

@section('libraryjs')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>

    <script>
        function initTable(data) {
            return new te.Datatable(
                dataTable, {
                    columns: column,
                    rows: data.map((item, index) => {
                        return {
                            no: index+1,
                            ...item
                        }
                    })
                }, {
                    hover: true,
                    stripped: true
                },
            );
        }
    </script>

    <script>
        const dataTable = document.getElementById('datatable');
        const misas = @json($misas);
        console.log(misas);


        const column = [{
            label: "No",
            field: "no",
            sort: true
        }, {
            label: "Name",
            field: "title",
            sort: true
        }, {
            label: "Category",
            field: "category",
            sort: true
        }, {
            label: "Date",
            field: "activity_datetime",
            sort: true
        }, {
            label: "Status",
            field: "status",
            sort: true
        }];

        var table = initTable(misas);

        document.getElementById('datatable-search-input').addEventListener('input', (e) => {
            table.search(e.target.value);
        });

        document.getElementById('category').addEventListener('change', function() {
            let misa_filtered = misas;
            if (this.value != 'all') {
                misa_filtered = misas.filter(item => item.category == this.value);
            }

            dataTable.replaceChildren();
            table = initTable(misa_filtered);

        });
    </script>
@endsection
