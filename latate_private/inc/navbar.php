<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="logo" href="index.php?view=home">LaTaTe</a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Users</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?view=user_new">New</a>
                    <a class="navbar-item" href="index.php?view=user_list">List</a>
                    <a class="navbar-item" href="index.php?view=user_search">Search</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Clients</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?view=client_new">New client</a>
                    <a class="navbar-item" href="index.php?view=client_list">List client</a>
                    <a class="navbar-item" href="index.php?view=client_search">Search client</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Orders</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?view=order_new">New order</a>
                    <a class="navbar-item" href="index.php?view=order_list">List order</a>
                    <a class="navbar-item" href="index.php?view=order_search">Search order</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Category</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?view=category_new">New</a>
                    <a class="navbar-item" href="index.php?view=category_list">List</a>
                    <a class="navbar-item" href="index.php?view=category_search">Search</a>
                </div>
            </div>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Products</a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="index.php?view=product_new">New</a>
                    <a class="navbar-item" href="index.php?view=product_list">List</a>
                    <a class="navbar-item" href="index.php?view=product_category">Order By Category</a>
                    <a class="navbar-item" href="index.php?view=product_search">Search</a>
                </div>
            </div>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?view=act_user&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-rounded in">My Account</a>
                    <a href="index.php?view=logout" class="button is-rounded out">Log out</a>
                </div>
            </div>
        </div>
    </div>

</nav>