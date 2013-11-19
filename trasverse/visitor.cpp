#include "node.h" 

void
Visitor::visit(Node* node)
{
  std::cout << node->getName() << std::endl; 
} 

