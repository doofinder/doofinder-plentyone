.PHONY: build push

build:
	@bin/build-plugin-set

push:
	git push
	@bin/build-plugin-set
