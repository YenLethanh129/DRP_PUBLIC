    $(document).ready(function () {
        $("#ingredient-form").validate({
            rules: {
                id: {
                    required: true,
                    digits: true
                },
                name: {
                    required: true
                },
                category: {
                    required: true
                },
                measurement_unit: {
                    required: true
                },
                calcium: {
                    number: true
                },
                calories: {
                    number: true
                },
                carbohydrate: {
                    number: true
                },
                cholesterol: {
                    number: true
                },
                fiber: {
                    number: true
                },
                iron: {
                    number: true
                },
                fat: {
                    number: true
                },
                monounsaturated_fat: {
                    number: true
                },
                polyunsaturated_fat: {
                    number: true
                },
                saturated_fat: {
                    number: true
                },
                potassium: {
                    number: true
                },
                protein: {
                    number: true
                },
                sodium: {
                    number: true
                },
                sugar: {
                    number: true
                },
                vitamin_a: {
                    number: true
                },
                vitamin_c: {
                    number: true
                }
            },
            messages: {
                id: {
                    required: "Please enter the ID.",
                    digits: "Please enter a valid ID (numeric value only)."
                },
                name: {
                    required: "Please enter the name."
                },
                category: {
                    required: "Please select a category."
                },
                measurement_unit: {
                    required: "Please select a measurement description."
                },
                calcium: {
                    number: "Please enter a valid number for calcium."
                },
                calories: {
                    number: "Please enter a valid number for calories."
                },
                carbohydrate: {
                    number: "Please enter a valid number for carbohydrate."
                },
                cholesterol: {
                    number: "Please enter a valid number for cholesterol."
                },
                fiber: {
                    number: "Please enter a valid number for fiber."
                },
                iron: {
                    number: "Please enter a valid number for iron."
                },
                fat: {
                    number: "Please enter a valid number for fat."
                },
                monounsaturated_fat: {
                    number: "Please enter a valid number for monounsaturated fat."
                },
                polyunsaturated_fat: {
                    number: "Please enter a valid number for polyunsaturated fat."
                },
                saturated_fat: {
                    number: "Please enter a valid number for saturated fat."
                },
                potassium: {
                    number: "Please enter a valid number for potassium."
                },
                protein: {
                    number: "Please enter a valid number for protein."
                },
                sodium: {
                    number: "Please enter a valid number for sodium."
                },
                sugar: {
                    number: "Please enter a valid number for sugar."
                },
                vitamin_a: {
                    number: "Please enter a valid number for Vitamin A."
                },
                vitamin_c: {
                    number: "Please enter a valid number for Vitamin C."
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('error-message');
                error.insertAfter(element);
            }
        })
    });