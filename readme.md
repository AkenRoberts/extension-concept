### Doctrine Extension Architecture Concept

I created this in an attempt to learn more about Doctrine Extensions,
so I could better assist in maintaining the existing package.

There is no metadata parsing yet (e.g. annotations), but metadata is stored
in a central [Registry](src/Common/Metadata/Registry.php) for retrieval later.
This might be more cumbersome than we want, as you'd need to pass it through
to extension listeners so they can retrieve the appropriate metadata.

One thing I do like is that parsed metadata are first-class objects.
See [TimestampableMetadata](src/Timestampable/TimestampableMetadata.php).

#### Architecture

See the [bootstrap](bootstrap.php) file for how the extensions are hooked
into Doctrine. From there, classes are well-commented for context.
