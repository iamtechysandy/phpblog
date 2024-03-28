<div class="navbar-container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">TechySandy Blog.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i> <!-- Font Awesome bars icon -->
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>



<div class="row justify-content-center mb-4"> <!-- Added mb-4 class for margin-bottom -->
    <div class="col-lg-6">
        <form action="search.php" method="GET" class="mb-3"> <!-- Added mb-3 class for margin-bottom -->
            <div class="input-group">
                <input type="text" name="query" id="search-input" placeholder="Search..." class="form-control">
                <button class="btn btn-primary" type="submit">
                    <span class="d-none d-lg-inline">Search</span> <!-- Show text only on larger devices -->
                    <span class="d-inline d-lg-none">🔍</span> <!-- Show icon only on smaller devices -->
                </button>
            </div>
            <div class="form-check form-check-inline mt-2"> <!-- Added mt-2 class for margin-top -->
                <input type="checkbox" class="form-check-input" id="search-in-content" name="search_in_content">
                <label class="form-check-label" for="search-in-content">Search in content</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="search-in-tags" name="search_in_tags">
                <label class="form-check-label" for="search-in-tags">Search in tags</label>
            </div>
        </form>
    </div>
</div>

<header class="site-header mt-4"> <!-- Added mt-4 class for margin-top -->
    <div class="header-content">
        <h1>TechySandy</h1>
        <p>Insights and resources for the tech-savvy</p>
    </div>
</header>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

