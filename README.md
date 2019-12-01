###Library for managing content

#####Content
- names ```array(<string>)```
- leads ```array(<string>)```
- contents ```array(<string>)```

#####Release
- releaseDate ```<DateTime>```
- hidden ```<bool>```

#####Blog

Category
- uuid ```<string>```
- parent ```<Category>```
- names ```array(<string>)```
- sites ```array(<string>)```

Entry
- uuid ```<string>```
- creationDate ```<DateTime>```
- release ```<Release>```
- content ```<Content>```
- categories ```array(<string>)```

#####News
- uuid ```<string>```
- creationDate ```<DateTime>```
- release ```<Release>```
- content ```<Content>```
- sites ```array(<string>)```

#####Page
- key ```<string>```
- content ```<Content>```

#####Translation
- key ```<string>```
- site ```<string>```
- contents ```array(<string>)```
