## Tärningsspel

Välkommen till tärningsspelet.

<form action="dice/init" method="post">
    <input type="text" placeholder="Fyll i ditt namn" name="player-name" required>
    <input type="submit" value="Starta ett nytt spel!">
</form>


### Regler

Alla spelare kastar en tärning och den som får högst börjar spelet med en spelrunda.

Det gäller att först samla på sig 100 poäng.

En spelrunda inleds av en spelare genom att den kastar alla tärningar.

Alla tärningar med ögon 2-6 summeras och adderas till totalen för nuvarande spelrunda. En tvåa är värd 2 poäng och en sexa är värd 6 poäng, och så vidare.

Spelaren bestämmer om ett nytt kast skall göras inom samma spelrunda för att försöka samla mer poäng. Eller så väljer spelaren att avbryta spelrundan och föra över de insamlade poängen till säkerhet i protokollet.

Om spelaren kastar en etta så avbryts spelrundan och turen går över till nästa spelare. Nuvarande spelare förlorar alla poäng som samlats in i nuvarande spelrunda.
