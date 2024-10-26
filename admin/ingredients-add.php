<?php include('includes/header.php'); ?>

<div class="container-fluid px-4 pb-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Ingredient
                <a href="ingredients-view.php" class="btn btn-outline-danger float-end">Back</a> 
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <!-- Ingredient Name -->
                <div class="mb-3">
                    <label for="name">Ingredient Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="Meat & Poultry">Meat & Poultry</option>
                        <option value="Vegetables">Vegetables</option>
                        <option value="Condiments">Condiments</option>
                        <option value="Spices & Herbs">Spices & Herbs</option>
                        <option value="Others">Others</option>
                        <option value="Cutlery">Cutlery</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="saveIngredient" class="btn btn-outline-primary">Save Ingredient</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>