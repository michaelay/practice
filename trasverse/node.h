#ifndef __NODE_H__
#define __NODE_H__

#include <vector> 
#include <string>
#include <boost/shared_ptr.hpp>
#include "visitor.h"

class Node; 
typedef boost::shared_ptr<Node> NodePtr; 
typedef std::vector<NodePtr> NodeList; 

class Node {
private: 
  NodeList _children; 
  std::string _name;

public: 
  Node();
  Node(const Node&); 
  Node& operator=(const Node&); 

  Node(const std::string& name); 
  std::string& getName(); 

  bool addChild(const NodePtr&);
  NodeList& getChildren(); 

  void accept(VisitorPtr&);
}; 

#endif
