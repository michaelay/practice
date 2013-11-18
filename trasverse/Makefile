all: trasverse

trasverse: node.o trasverse.o
		g++ node.o trasverse.o -o trasverse

node.o: node.cpp
		g++ -c node.cpp

trasverse.o: trasverse.cpp
		g++ -c trasverse.cpp

clean:
		rm -rf *o trasverse
