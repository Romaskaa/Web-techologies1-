class Pizza {

    static pizzas = {
        "Маргарита": {
            price: 500,
            calories: 300
        },
        "Пепперони": {
            price: 800,
            calories: 400
        },
        "Баварская": {
            price: 700,
            calories: 450
        }
    }

    static sizes = {
        "Большая": {
            price: 200,
            calories: 200
        },
        "Маленькая": {
            price: 100,
            calories: 100
        }
    }

    static toppings = {
        "Сливочная моцарелла": {
            price: 50,
            calories: 20
        },
        "Сырный борт": {
            small: {
                price: 150,
                calories: 50
            },
            large: {
                price: 300,
                calories: 50
            }
        },
        "Чедер и пармезан": {
            small: {
                price: 150,
                calories: 50
            },
            large: {
                price: 300,
                calories: 50
            }
        }
    }

    constructor(type, size) {

        if (!Pizza.pizzas[type]) {
            throw new Error("Такого вида пиццы нет");
        }

        if (!Pizza.sizes[size]) {
            throw new Error("Такого размера пиццы нет");
        }

        this.type = type;
        this.size = size;
        this.toppings = [];
    }

    addTopping(topping) {
        if (!Pizza.toppings[topping]) {
            throw new Error("Такой добавки нет");
        }   
        this.toppings.push(topping);
    }

    removeTopping(topping) {
        const index = this.toppings.indexOf(topping);
        if (index === -1) {
            throw new Error("Такой добавки нет");
        }
        this.toppings.splice(index, 1);
    }

    getToppings() {
        return this.toppings;
    }

    getSize() {
        return this.size;
    }

    getStuffing() {
        return this.type;
    }

    calculatePrice() {
        let price = Pizza.pizzas[this.type].price + Pizza.sizes[this.size].price;
        
        for (const topping of this.toppings) {
            if (topping === "Сливочная моцарелла") {
                price += Pizza.toppings[topping].price;
            } else {
                if (this.size === "Большая") {
                    price += Pizza.toppings[topping].large.price;
                } else {
                    price += Pizza.toppings[topping].small.price;
                }
            }
        }
        return price;
    }

    calculateCalories() {
        let calories = Pizza.pizzas[this.type].calories + Pizza.sizes[this.size].calories;

        for (const topping of this.toppings) {
            if (topping === "Сливочная моцарелла") {
                calories += Pizza.toppings[topping].calories;
            } else {
                if (this.size === "Большая") {
                    calories += Pizza.toppings[topping].large.calories;
                } else {
                    calories += Pizza.toppings[topping].small.calories;
                }
            }
        }
        return calories;
    }
};

const orderButton = document.querySelector(".order-button");
const resultDiv = document.querySelector("#result");

function updateCalculator() {
    const selectedType = document.querySelector("input[name='pizza']:checked");
    const selectedSize = document.querySelector("input[name='size']:checked");
    const selectedToppings = document.querySelectorAll("input[name='toppings']:checked");

    if (!selectedType || !selectedSize) {
        return;
    }
    
    const pizza = new Pizza(selectedType.value, selectedSize.value);

    selectedToppings.forEach(topping => {
        pizza.addTopping(topping.value);
    });

    const totalPrice = pizza.calculatePrice();
    const totalCalories = pizza.calculateCalories();

    orderButton.innerHTML = `Добавить в корзину за <br> ${totalPrice} рублей (${totalCalories} кКалл)`;
};

document.querySelectorAll("input").forEach(input => {
    input.addEventListener("change", updateCalculator);
});

orderButton.addEventListener("click", () => {
    const selectedType = document.querySelector("input[name='pizza']:checked");
    const selectedSize = document.querySelector("input[name='size']:checked");
    const selectedToppings = document.querySelectorAll("input[name='toppings']:checked");

    if (!selectedType || !selectedSize) {
        alert("Пожалуйста, выберите вид и размер пиццы");
        return;
    }
    
    const pizza = new Pizza(selectedType.value, selectedSize.value);

    selectedToppings.forEach(topping => {
        pizza.addTopping(topping.value);
    });

    if (selectedToppings.length === 0) { 
        resultDiv.innerHTML = `
        <p style="text-align: center; margin: 0px 0px; text-decoration: underline;">Ваш заказ</p> 
        ${pizza.getSize()} ${pizza.getStuffing().toLowerCase()}.<br> 
        Цена: ${pizza.calculatePrice()} рублей. <br>
        Калории: ${pizza.calculateCalories()} кКалл.`; 
    } else { 
        resultDiv.innerHTML = `
        <p style="text-align: center; margin: 0px 0px; text-decoration: underline;">Ваш заказ</p> 
        ${pizza.getSize()} ${pizza.getStuffing().toLowerCase()} 
        с добавками ${pizza.getToppings().map(t => t.toLowerCase()).join(", ")}.<br> 
        Цена: ${pizza.calculatePrice()} рублей. <br>
        Калории: ${pizza.calculateCalories()} кКалл.`; 
    }
});