<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex justify-content-center">
            <form class="d-flex w-100 align-items-center" action="{{ route('search') }}" method="get">
                <input 
                    class="form-control me-2 flex-grow-1" 
                    type="search" 
                    name="query" 
                    placeholder="Search" 
                    aria-label="Search"
                >
                <button class="btn btn-warning" type="submit">Search</button>
            </form>
        </div>
    </div>
</div>
