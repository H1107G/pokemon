<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Showcase</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            padding: 30px;
        }

        #poken { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 30px; 
            padding: 20px;
        } 

        .pokemon-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            overflow: hidden;
        }

        .pokemon-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .pokemon-card img {
            border-radius: 50%;
            border: 6px solid #f7f7f7;
            width: 160px;
            height: 160px;
            margin-bottom: 15px;
            background-color: #e9ecef;
        }

        .pokemon-name {
            font-size: 1.5em;
            font-weight: 600;
            color: #333;
            text-transform: capitalize;
            margin-bottom: 10px;
            padding: 10px 15px;
            background-color: #ffd166;
            border-radius: 25px;
            text-align: center;
        }

        .pokemon-type {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            background-color: #06d6a0;
            font-size: 1em;
            color: white;
            border-radius: 10px;
            margin-top: 10px;
        }

        .pokemon-type span {
            margin: 3px 0;
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .pokemon-card:hover img {
            border-color: #ffd166;
        }
    </style>
</head>
<body>
    <div id="poken"></div>

    <script>
        function loadapi(){
            fetch('https://pokeapi.co/api/v2/pokemon?limit=100&offset=0')
            .then(response => { 
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let pokemons = data.results;
                let maindiv = document.getElementById("poken");

                pokemons.forEach(pokemon => {          
                    fetch(pokemon.url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(characteristics => {
                        const card = document.createElement("div");
                        card.classList.add("pokemon-card");

                        // Fetch species for background color
                        fetch(characteristics.species.url)
                        .then(response => response.json())
                        .then(speciesData => {
                            card.style.backgroundColor = speciesData.color.name;
                        });

                        // Create name element
                        const nameElement = document.createElement("div");
                        nameElement.classList.add("pokemon-name");
                        nameElement.innerHTML = pokemon.name;

                        // Create type element
                        const typeElement = document.createElement("div");
                        typeElement.classList.add("pokemon-type");
                        characteristics.types.forEach(typeData => {
                            const typeSpan = document.createElement("span");
                            typeSpan.textContent = typeData.type.name;
                            typeElement.appendChild(typeSpan);
                        });

                        // Create image element
                        const img = document.createElement("img");
                        img.setAttribute("src", characteristics.sprites.front_default);

                        // Append elements to card
                        card.appendChild(img);
                        card.appendChild(nameElement);
                        card.appendChild(typeElement);

                        maindiv.appendChild(card);
                    });
                });
            }) 
            .catch(error => console.error('Error:', error));
        }

        loadapi();
    </script>
</body>
</html>
