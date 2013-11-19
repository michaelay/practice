all: trasverse

trasverse: node.o visitor.o trasverse.o
		g++ node.o visitor.o trasverse.o -o trasverse

node.o: node.cpp
		g++ -c node.cpp

visitor.o: visitor.cpp
		g++ -c visitor.cpp

trasverse.o: trasverse.cpp
		g++ -c trasverse.cpp

clean:
		rm -rf *o trasverse
