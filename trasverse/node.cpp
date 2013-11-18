#include "node.h" 

Node::Node() 
{
}

Node::Node(const Node&)
{
} 

Node& 
Node::operator=(const Node& node)
{
  _children = node._children;
  return *this;
}

Node::Node(const std::string& name)
{
  _name = name; 
}

std::string& 
Node::getName()
{
  return _name;
}

bool 
Node::addChild(const NodePtr& nodePtr)
{
  _children.push_back(nodePtr);
  return true; 
}

NodeList& 
Node::getChildren() 
{
  return _children; 
}
