# train_routes_api
Example of job interview assignment - Train routes api

# Zadanie #
1. Napisz serwis API zgodnie z dokumentacją,
2. Napisz testy automatyczne dla obu endpointów,
3. Zadanie może zostać wykonane z użyciem dowolnej technologii,
4. Użyj Gita do udokumentowania historii projektu,
5. Logowanie nie jest wymagane

# Dokumentacja #

1. **Add train** <br />
Endpoint do dodawania połączenia kolejowego. Dodanie połączenia Wrocław -> Warszawa nie oznacza, że istnieje połączenie Warszawa -> Wrocław.

HTTP REQUEST `POST http://example.com/api/trains` <br />JSON Payload:
```json
{
  "train": ["Poznań", "Wadowice"]
}
```

**Walidacje:**

- Trasa jest unikalna - nie można dodać dwa razy tej samej,
- Nie można dodać trasy A->A. W każdym scenariuszu serwer powinien zwrócić odpowiedni status HTTP.

2. **Find shortest route** <br />
Endpoint do wyszukiwania najkrótszej trasy pomiędzy dwoma miastami. Zwraca wiele tras jeśli mają tę samą długość.

HTTP REQUEST `GET http://example.com/api/shortest_route?start=START&destination=DESTINATION`

Request params:
```json
{
  "start": "Poznań",
  "destination": "Wadowice"
}
```

JSON Response:

```json
{
  "routes": [
    [
      "Poznań",
      "Wrocław",
      "Wadowice"
    ],
    [
      "Poznań",
      "Łódź",
      "Wadowice"
    ]
  ],
  "distance": 2
}
```
Jeśli połączenie między miastami nie istnieje, aplikacja zwraca status 404.

# Dodatkowe punkty za: #
1. jak najlepiej zoptymalizowany algorytm (szybkość i potrzebne zasoby),
2. implementację systemu cachingu (dla ułatwienia cache kasowany przy dodaniu pociągu)
3. użycie nierelacyjnej bazy danych
